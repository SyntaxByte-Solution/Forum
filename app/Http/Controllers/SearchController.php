<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\{Thread, User, Forum, Vote, Like};

class SearchController extends Controller
{
    public function search(Request $request) {
        $tab = 'all';
        $tab_title = __('All');

        $pagesize = 10;
        $pagesize_exists = false;
        if($request->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = $request->input('pagesize');
        }

        $keyword = $request->validate([
            'k'=>'sometimes|max:2000'
        ]);

        if(empty($keyword)) {
            $search_query = '';
        } else {
            $search_query = $keyword['k'];
        }

        
        $forums = Forum::all();
        $threads = Thread::whereIn('id', array_column(
            DB::select(
                $this->search_query_generator('threads', $search_query, ['subject', 'content'], ['LIKE'], ['OR'])
            ), 'id'
        ));

        if($request->has('tab')) {
            $tab = $request->input('tab');
            if($tab == 'today') {
                $threads = $threads->today()->orderBy('view_count', 'desc');
                $tab_title = __('Today');
            } else if($tab == 'thisweek') {
                $threads = $threads->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc');
                $tab_title = __('This week');
            }
        }

        $threads = $threads->orderBy('created_at', 'desc')->paginate($pagesize);

        $users = User::excludedeactivatedaccount()->whereIn('id', array_column(
            DB::select(
                $this->search_query_generator('users', $search_query, ['firstname', 'lastname', 'username'], ['LIKE'], ['OR'])
            ), 'id'
        ))->orderBy('username', 'asc')->paginate(4);

        return view('search.search-result')
            ->with(compact('forums'))
            ->with(compact('threads'))
            ->with(compact('users'))
            ->with(compact('pagesize'))
            ->with(compact('search_query'))
            ->with(compact('tab'))
            ->with(compact('tab_title'));
    }

    public function search_advanced(Request $request) {
        $forums = Forum::all();
        return view('search.search-advanced')
            ->with(compact('forums'));
    }

    public function search_advanced_results(Request $request) {
        $tab = 'all';
        $tab_title = __('All');

        $filters = [];
        $forums = Forum::all();

        $pagesize = 6;
        $threads = Thread::query();
        $keywords;

        $data = $request->validate([
            'k'=>'required|min:1|max:2000',
            'forum'=> [
                'sometimes',
                function ($attribute, $value, $fail) use (&$keywords) {
                    $forums_ids = Forum::all()->pluck('id')->toArray();
                    $forums_ids[] = 0;

                    if(!in_array($value, $forums_ids)) {
                        $fail('The '.$attribute."  doesn't exists in our records.");
                    }
                },
            ],
            'category'=>[
                'sometimes',
                function ($attribute, $value, $fail) use (&$filters) {
                    // request()->forum != 0 means the user select a forum
                    // request()->forum == 0; means user select All forums
                    if(($forum = request()->forum) != 0) {
                        $categories_ids = Forum::find($forum)->categories->pluck('id')->toArray();
                        $categories_ids[] = 0;

                        if(!in_array($value, $categories_ids)) {
                            $fail('The '.$attribute." doesn't exists in our records.");
                        } else {
                            if($value != 0) {
                                $filters[] = [__('Category'), \App\Models\Category::find($value)->category, 'category'];
                            }
                        }
                    } else {
                        if($value != 0) {
                            $fail('Invalid '.$attribute." value");
                        }
                    }
                },
            ],
            'threads_date'=> [
                'sometimes',
                Rule::in(['anytime', 'past24hours', 'pastweek', 'pastmonth', 'pastyear']),
            ],
            'sorted_by'=>[
                'sometimes',
                Rule::in(['created_at_desc', 'created_at_asc', 'views', 'votes', 'likes']),
            ]
        ]);

        $query_string = $data['k'];
        $keywords = array_filter(explode(' ', $query_string));
        usort($keywords, function($a, $b){
            return strlen($a) < strlen($b);
        });
         

        // request()->forum != 0 means the user select a forum
        // request()->forum == 0; means user select All forums
        if(isset($data['forum']) && ($forum = $data['forum']) != 0) {
            // We check for category because if there's forum and category submitted we want the forum to be first
            if($request->category) {
                array_unshift($filters, [__('Forum'), Forum::find($forum)->forum, 'forum']);
            } else {
                $filters[] = [__('Forum'), Forum::find($forum)->forum, 'forum'];
            }
            $categories_ids = Forum::find($forum)->categories->pluck('id')->toArray();
            
            if(!isset($data['category']) || $data['category'] == '0') {
                /**
                 * Get threads for all categories of the forum that match the search query
                 * Notice here we have to use conditional groups because threads will be fetched like following
                 * First we fetch threads from categories of the selected forum
                 * then we open a group to place all the conditions:
                 *  1. we compare threads subject with the whole query_string using like operator
                 *  2. we compare threads content with the whole query_string using like operator
                 *  3. then we pass the keywords to the nested group to fetch all threads with either subject or content like keyword
                 * WHERE category_id IN (1, 2, 3) AND (subject like '%keyword%' || content like '%keyword%')
                 */
                $threads = Thread::whereIn('category_id', $categories_ids)
                    ->where(function($query) use ($query_string,$keywords) {
                        $query->where('subject', 'like', "%$query_string%")
                            ->orWhere('content', 'like', "%$query_string%")
                            ->orWhere(function($q) use ($keywords) {
                                foreach($keywords as $keyword) {
                                    $q->where('subject','like',"%$keyword%")
                                            ->orWhere('content','like',"%$keyword%");
                                }
                            });
                    });
            } else {
                // Get threads for category of the forum that match the search query
                $threads = 
                    Thread::where('category_id', $data['category'])
                    ->where(function($query) use ($query_string, $keywords) {
                        $query->where('subject', 'like', "%$query_string%")
                        ->orWhere('content', 'like', "%$query_string%")
                        // see notice above where $value = '0'
                        ->orWhere(function($query) use ($keywords) {
                            foreach($keywords as $keyword) {
                                $query->where('subject','like',"%$keyword%")
                                ->orWhere('content','like',"%$keyword%");
                            }
                        });
                });
            }
        } else {
            /**
             * get all threads of all forums categories that match one of search query keywords
             * Notice that here also we need to use groupings because we need OR operators
             * between keywords checks
             * eg. :
             * keyword = mouad nassri => keywords = ['mouad','nassri']
             * SELECT * FROM threads 
             * where `subject` LIKE '%mouad nassri%'
             * OR `content` LIKE '%mouad nassri%'
             * OR `subject` LIKE '%mouad%'
             * OR `subject` LIKE '%nassri%'
             * OR `content` LIKE '%mouad%'
             * OR `content` LIKE '%nassri%'
             */
            $threads = 
                Thread::where('subject', 'like', "%$query_string%")
                    ->orWhere('content', 'like', "%$query_string%")
                    ->orWhere(function($query) use ($keywords) {
                        foreach($keywords as $keyword) {
                            $query->where('subject', 'like', "%$keyword%")
                            ->orWhere('content', 'like', "%$keyword%");
                        }
                    });
        }

        if(isset($request->hasbestreply)) {
            $filters[] = [__('Best replied'), __('ON'), 'hasbestreply'];
            $threads = $threads->ticked();
        }

        if(isset($data['threads_date'])) {
            switch($data['threads_date']) {
                case 'past24hours':
                    $filters[] = [__('Date'), __('Past 24 hours'), 'threads_date'];
                    $threads = $threads->where("created_at",">",Carbon::now()->subDay(1));
                    break;
                case 'pastweek':
                    $filters[] = [__('Date'), __('Last week'), 'threads_date'];
                    $threads = $threads->where("created_at",">",Carbon::now()->subDays(7));
                    break;
                case 'pastmonth':
                    $filters[] = [__('Date'), __('Last month'), 'threads_date'];
                    $threads = $threads->where("created_at",">",Carbon::now()->subMonth());
                    break;
                case 'pastyear':
                    $filters[] = [__('Date'), __('Last year'), 'threads_date'];
                    $threads = $threads->where("created_at",">",Carbon::now()->subYear());
                    break;
            }
        }

        if(isset($data['sorted_by'])) {
            switch($data['sorted_by']) {
                case 'created_at_desc':
                    $filters[] = [__('Sort by'), __('creation date(desc)'), 'sorted_by'];
                    $threads = $threads->orderBy('created_at', 'desc');
                    break;
                case 'created_at_asc':
                    $filters[] = [__('Sort by'), __('creation date(asc)'), 'sorted_by'];
                    $threads = $threads->orderBy('created_at');
                    break;
                case 'views':
                    $filters[] = [__('Sort by'), __('views'), 'sorted_by'];
                    // We plan to separate thread view to new table
                    $threads = $threads->orderBy('view_count', 'desc');
                    break;
                case 'votes':
                    $filters[] = [__('Sort by'), __('votes'), 'sorted_by'];
                    $threads = $threads->withCount('votes')->orderBy('votes_count', 'desc');
                    break;
                case 'likes':
                    $filters[] = [__('Sort by'), __('likes'), 'sorted_by'];
                    $threads = $threads->withCount('likes')->orderBy('likes_count', 'desc');
                    break;
            }
        }
        
        $threads = $threads->paginate($pagesize);
        $search_query = $data['k'];
        
        return view('search.search-threads')
            ->with(compact('filters'))
            ->with(compact('forums'))
            ->with(compact('threads'))
            ->with(compact('pagesize'))
            ->with(compact('tab'))
            ->with(compact('tab_title'))
            ->with(compact('search_query'));
    }

    public function threads_search(Request $request) {
        $tab = 'all';
        $tab_title = __('All');

        $pagesize = 10;
        $pagesize_exists = false;
        if($request->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = $request->input('pagesize');
        }

        $keyword = $request->validate([
            'k'=>'sometimes|max:2000'
        ]);

        if(empty($keyword)) {
            $search_query = '';
        } else {
            $search_query = $keyword['k'];
        }

        
        $forums = Forum::all();
        $threads = Thread::whereIn('id', array_column(
            DB::select(
                $this->search_query_generator('threads', $search_query, ['subject', 'content'], ['LIKE'], ['OR'])
            ), 'id'
        ));

        if($request->has('tab')) {
            $tab = $request->input('tab');
            if($tab == 'today') {
                $threads = $threads->today()->orderBy('view_count', 'desc');
                $tab_title = __('Today');
            } else if($tab == 'thisweek') {
                $threads = $threads->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc');
                $tab_title = __('This week');
            }
        }

        $threads = $threads->orderBy('created_at', 'desc')->paginate($pagesize);

        return view('search.search-threads')
            ->with(compact('forums'))
            ->with(compact('threads'))
            ->with(compact('pagesize'))
            ->with(compact('tab_title'))
            ->with(compact('search_query'));
    }

    public function users_search(Request $request) {
        $pagesize = 8;
        $pagesize_exists = false;
        if($request->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = $request->input('pagesize');
        }

        $keyword = $request->validate([
            'k'=>'sometimes|max:2000'
        ]);

        if(empty($keyword)) {
            $search_query = '';
        } else {
            $search_query = $keyword['k'];
        }

        
        $forums = Forum::all();
        $query = $this->ksearch('users', $search_query, ['firstname', 'lastname', 'username'], ['LIKE']);
        $users = User::excludedeactivatedaccount()->whereIn('id', array_column(
            DB::select($query['query'], $query['bindings']), 'id'
        ))->orderBy('username', 'asc')->paginate($pagesize);

        return view('search.search-users')
            ->with(compact('forums'))
            ->with(compact('users'))
            ->with(compact('pagesize'))
            ->with(compact('search_query'));
    }

    /**
     * The following function is used to fetch records from databse table specified in the $table parameter and
     * return results in form of collection of type specified in $table parameter.
     * 1. It takes a table as its first parameter to fetch the records
     * 2. search query will be split it up into space-separated keywords. eg: "MOUAD NASSRI" => ['MOUAD','NASSRI']
     * 3. columns parameter specify the table's columns that are used to compare with the keywords.
     * 4. column_keyword_condition_operators(array): is an array of operators used to specify the operator between each
     *    column and keyword. eg: ['==', 'LIKE'] => SELECT * FROM foo WHERE column1 == keyword && column2 LIKE keyword
     *    Note: Notice that the number of column operators must be exactly the same as columns number
     *    Note: If the number of operators is less than number of columns it will fill the gaps with the last
     *    operator. if the operators array is empty it will populated automatically with == operators
     * 5. conditional_operators(array): is the array of conditional operators.
     *    eg: ['&&', '||'] => SELECT * FROM foo WHERE a == boo && b = zoo || c == grotto
     *    if no paramter is given it will replaced by array of OR operators
     *    Notice that the number of operators should be equal to count($columns) - 1
     * 
     *    RETURN: returns the generated query for search
     */
    private function search_query_generator($table, $search_query='', 
                        $columns=[], $operators=[], $conditional_operators=[]) {
        $keywords = array_filter(explode(' ', $search_query));

        if(empty($columns) || empty($keywords)) {
            return "SELECT * FROM $table";
        }
        // If number of operators > number of columns return false;
        if(count($operators) > count($columns)) {
            return false;
        }

        if(empty($operators)) {
            $operators = array_fill(0, count($columns), $this->default_operator);
        } // If the number of operators < number of bolumns then we fill in the gaps with the last element
        else if(count($operators) < count($columns)) {
            $last_element = $operators[count($operators)-1];
            for($i=count($operators);$i<count($columns);$i++) {
                $operators[] = $last_element;
            }
        }
        if(empty($conditional_operators)) {
            $conditional_operators = array_fill(0, count($columns)-1, $this->default_conditional_operator);
        } // We do the same thing with conditional operators array
        else if(count($conditional_operators) < count($columns)-1) {
            $last_element = $conditional_operators[count($conditional_operators)-1];
            for($i=count($conditional_operators);$i<count($columns)-1;$i++) {
                $conditional_operators[] = $last_element;
            }
        }

        $first_iteration = true;
        $fi = true;
        $i = 0;
        $j = 0;

        $query = "SELECT * FROM $table ";
        
        foreach($columns as $column) {
            if($first_iteration) {
                $query .= "WHERE `$column` LIKE '%$search_query%' ";
                $first_iteration = false;
            } else {
                $query .= "OR `$column` LIKE '%$search_query%' ";
            }

            foreach($keywords as $keyword) {    
                if($operators[$i] == 'LIKE') {
                    $keyword = "%$keyword%";
                }
                $query .= "$conditional_operators[$j] `$column` $operators[$i] '$keyword' ";
            }
            $i++;
            if(!$fi) {
                $j++;
            }
            $fi = false;
        }
        return trim($query);
        //return $model::whereIn('id', $model::hydrate(DB::select($query))->pluck('id'));
    }

    private $default_operator = "=";
    private $default_conditional_operator = "AND";
    /**
     * Building a query in string format based on user input and pass it to DB facade as raw sql is vulnerable.
     * We have to pass it as prepared statement and passing the bindings along with it as array of operands
     * for that purpose I decided to build this function from scratch into this new method
     * Notice that this function doesn't support conditional grouping of logical operators between conditions
     * We're going to implement it later
     * 
     * NOTICE: Search results should be fetched in cetain priority for example the most prioritized search parameter 
     *         is the full search query, then we space-explode the query string and take exploded keywords [here also 
     *         we prioritize the keywords based on keyword length] ..etc
     *         $result is an array of arrays; arrays will be appended to $result for every search priority
     * return: It returns array of results (Query builder select method)
     */
    private function ksearch($table, $search_query, $columns=[], $operators=[]) {
        $query = "SELECT * FROM $table ";
        $bindings = [];

        $keywords = array_filter(explode(' ', $search_query));
        $result = [];

        if(empty($columns) || $search_query == "") {
            return [
                "query"=>trim($query),
                "bindings"=>$bindings
            ];
        }

        $query .= 'WHERE';
        /**
         * It is imposible to have number of operators > number of columns so we return false when that happen;
         * (Notice that this check is applied only to developer function call and doesn't have any relation with search query)
         * for operators is less than columns we handled it in the else if statement of operators empty checking
         */ 
        if(count($operators) > count($columns)) {
            return collect([]);
        }
        // Filling the gaps if empty or not enough operators present
        if(empty($operators)) {
            $operators = array_fill(0, count($columns), $this->default_operator);
        } // If the number of operators < number of columns then we fill in the gaps with the last element
        else if(count($operators) < count($columns)) {
            $last_element = $operators[count($operators)-1];
            for($i=count($operators);$i<count($columns);$i++) {
                $operators[] = $last_element;
            }
        }

        // First search priority is to search for the whole query_string in every column
        // But before that we have to check wether it container multiple keywords separated by space or not
        if(count($keywords) > 1) {
            for($i=0; $i < count($columns); $i++) {
                if($i != 0) $query .= "OR";
                if(strtolower($operators[$i]) == 'like') $search_query = "%$search_query%";
                $query .=  " $columns[$i] $operators[$i] ? "; // eg: WHERE firstname != ?, [$search_query]
                $bindings[] = $search_query;
            }
        }

        // Here we can sort keywords list by length descending order, but for now let's keep it as it is
        $first_iteration = true;
        $c = 0;
        for($i=0; $i < count($columns); $i++) {
            foreach($keywords as $keyword) {
                if((count($keywords) == 1 && $first_iteration)) {
                    /**
                     * If the iteration is the frist one and the keywords count is 1, we don't have to add OR
                     * because we have already appended WHERE to query (look above right after checking for $columns empty)
                     */
                    $first_iteration=false;
                } else {
                    $query.="OR";
                }

                if(strtolower($operators[$i]) == 'like') $keyword = "%$keyword%";
                $query .= " $columns[$i] $operators[$i] ? ";
                $bindings[] = $keyword;
            }
        }

        return [
            "query"=>trim($query),
            "bindings"=>$bindings
        ];
    }

    /**
     * NOTICE: logical groups will be determined by the nature of element in conditional_operators parameter
     * for example if we pass an array as operator, it will be considered as a group
     * eg: [[AND], OR] => (A==? && B==?) || C==?;
     * When we loop through conditional_operators and get into an element of type array, we know that we have a group
     * and we loop further by the length of array(group)+1 columns and handle the group syntax
     */
    public function qsearch($table, $search_query, $columns=[], $operators=[], $conditional_operators=[]) {
        $sql = "SELECT * FROM $table";
        $bindings = [];
        $keywords = array_filter(explode(' ', $search_query));
        $result = [];

        if(empty($columns)) {
            return DB::select($sql);
        }
        /**
         * It is imposible to have number of operators > number of columns so we return false when that happen;
         * (Notice that this check is applied only to developer function call and doesn't have any relation with search query)
         * for operators is less than columns we handled it in the else if statement of operators empty checking
         */ 
        if(count($operators) > count($columns)) {
            return collect([]);
        }
        // Filling the gaps if empty or not enough operators present
        if(empty($operators)) {
            $operators = array_fill(0, count($columns), $this->default_operator);
        } // If the number of operators < number of columns then we fill in the gaps with the last element
        else if(count($operators) < count($columns)) {
            $last_element = $operators[count($operators)-1];
            for($i=count($operators);$i<count($columns);$i++) {
                $operators[] = $last_element;
            }
        }
        // Filling the gaps if empty or not enough conditional operators present
        if(empty($conditional_operators)) {
            $conditional_operators = array_fill(0, count($columns)-1, $this->default_conditional_operator);
        } // We do the same thing with conditional operators array
        else if(count($conditional_operators) < count($columns)-1) {
            $last_element = $conditional_operators[count($conditional_operators)-1];
            // Notice: $i < count($columns)-1 because conditional operators are always equal to number of checks - 1
            for($i=count($conditional_operators);$i<count($columns)-1;$i++) {
                $conditional_operators[] = $last_element;
            }
        }
    }
}
