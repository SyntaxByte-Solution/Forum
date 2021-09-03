<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Forum;
use Illuminate\Validation\Rule;

class GeneralController extends Controller
{
    public function get_forum_categories_ids(Forum $forum) {
        $category_id = $forum->categories()->excludeannouncements()->pluck('category', 'id');
        $category_id = $category_id->map(function($item) { 
            return __($item);
        });
        return \json_encode($category_id);
    }

    public function setlang(Request $request) {
        $lang = $request->validate([
            'lang'=>[
                'required',
                Rule::in(['en', 'fr', 'ma-ar']),
            ]
        ]);

        Cookie::queue('lang', $lang['lang'], 2628000);
    }
}
