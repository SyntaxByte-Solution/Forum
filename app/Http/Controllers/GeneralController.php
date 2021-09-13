<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Forum;
use Illuminate\Validation\Rule;
use App\View\Components\User\Quickaccess;

class GeneralController extends Controller
{
    public function get_forum_categories_ids(Forum $forum) {
        $data = [];
        $forumslug = $forum->slug;
        foreach($forum->categories()->excludeannouncements()->get() as $category) {
            $data[] = [
                'id'=>$category->id,
                'category'=>__($category->category),
                // Reason we don't use category link attribute is beacause we return a forum object in every category (performence purposes)
                'link'=>route('category.threads', ['forum'=>$forumslug, 'category'=>$category->slug]),
                'forum_link'=>route('forum.all.threads', ['forum'=>$forumslug])
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
    public function generate_quickaccess() {
        $quickaccess = new Quickaccess();
        $quickaccess = $quickaccess->render(get_object_vars($quickaccess))->render();
        return $quickaccess;
    }
    public function update_user_last_activity() {
        $expiresAt = \Carbon\Carbon::now()->addMinutes(4);
        \Cache::put('user-is-online-' . \Auth::user()->id, true, $expiresAt);
    }
}
