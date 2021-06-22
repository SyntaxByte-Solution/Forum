<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Thread, User, Forum};

class SearchController extends Controller
{
    public function search(Request $request) {
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
        ))->orderBy('created_at', 'desc')->paginate($pagesize);

        $users = User::whereIn('id', array_column(
            DB::select(
                $this->search_query_generator('users', $search_query, ['firstname', 'lastname', 'username'], ['LIKE'], ['OR'])
            ), 'id'
        ))->orderBy('username', 'asc')->paginate(5);

        return view('search.search-result')
            ->with(compact('forums'))
            ->with(compact('threads'))
            ->with(compact('users'))
            ->with(compact('pagesize'))
            ->with(compact('search_query'));
    }

    public function threads_search(Request $request) {
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
        ))->orderBy('created_at', 'desc')->paginate($pagesize);

        return view('search.search-threads')
            ->with(compact('forums'))
            ->with(compact('threads'))
            ->with(compact('pagesize'))
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
        $users = User::whereIn('id', array_column(
            DB::select(
                $this->search_query_generator('users', $search_query, ['firstname', 'lastname', 'username'], ['LIKE'], ['OR'])
            ), 'id'
        ))->orderBy('username', 'asc')->paginate($pagesize);

        return view('search.search-users')
            ->with(compact('forums'))
            ->with(compact('users'))
            ->with(compact('pagesize'))
            ->with(compact('search_query'));
    }

    private $default_operator = "=";
    private $default_conditional_operator = "AND";

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
            foreach($keywords as $keyword) {
                if($first_iteration) {
                    if($operators[$i] == 'LIKE') {
                        $keyword = "%$keyword%";
                    }
                    $query .= "WHERE `$column` $operators[$i] '$keyword' ";
                    $first_iteration = false;
                } else {
                    if($operators[$i] == 'LIKE') {
                        $keyword = "%$keyword%";
                    }
                    $query .= "$conditional_operators[$j] `$column` $operators[$i] '$keyword' ";
                }
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
}
