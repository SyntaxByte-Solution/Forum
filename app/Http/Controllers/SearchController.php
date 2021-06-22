<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Thread, User};

class SearchController extends Controller
{
    public function search(Request $request) {
        $keyword = $request->validate([
            'k'=>'required|max:2000'
        ]);

        dd($this->resource_spider(Thread::class, $keyword['k'], ['subject', 'content'], ['LIKE'], ['OR']));
        
        // dd($keywords);

        return view('search.search-result')
            ->with(compact('original_keyword'));
    }

    private $default_operator = "=";
    private $default_conditional_operator = "AND";

    /**
     * The following function is used to fetch records from databse table specified in the $table parameter and
     * return results in form of collection of type specified in $table parameter.
     * 1. It takes a model as the first parameter and it will be used to fetch table name as well as the final results
     * 2. keyword will be in form of array of space-separated keywords. eg: "MOUAD NASSRI" => ['MOUAD','NASSRI']
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
     */
    private function resource_spider($model, $keyword='', $columns=[], $operators=[], $conditional_operators=[]) {
        $keywords = array_filter(explode(' ', $keyword));
        // Extract table name from model
        $table = (new $model)->getTable();

        if(empty($columns) || $keyword == "") {
            return DB::select("SELECT * FROM $table");
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
                $conditional_operators[] = $this->default_conditional_operator;
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

        return $model::hydrate(DB::select($query));
    }
}
