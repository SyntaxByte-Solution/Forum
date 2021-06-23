<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;

class GeneralController extends Controller
{
    public function get_forum_categories_ids(Forum $forum) {
        $f = $forum;
        return \json_encode($forum->categories->where('slug', '<>', 'announcements')->pluck('category', 'id'));
    }
}
