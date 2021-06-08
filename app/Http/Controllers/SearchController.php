<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function forum_search() {
        $data = request()->validate([
            'k'=>'required|max:2000'
        ]);
        
        return view('search.forum-search-result');
    }
}
