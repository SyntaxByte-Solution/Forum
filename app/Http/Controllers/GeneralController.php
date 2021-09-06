<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Forum;
use Illuminate\Validation\Rule;

class GeneralController extends Controller
{
    public function get_forum_categories_ids(Forum $forum) {
        $data = [];
        foreach($forum->categories()->excludeannouncements()->get() as $category) {
            $data[] = [
                'id'=>$category->id,
                'category'=>$category->category,
                'link'=>route('category.threads', ['forum'=>$category->forum->slug, 'category'=>$category->slug]),
                'forum_link'=>route('forum.all.threads', ['forum'=>$category->forum->slug])
            ];
        }
        return \json_encode($data);
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
