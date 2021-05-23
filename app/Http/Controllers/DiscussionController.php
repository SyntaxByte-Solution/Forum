<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;

class DiscussionController extends Controller
{
    public function create(Forum $forum) {
        $categories = $forum->categories;

        return view('discussion.create')
        ->with(compact('categories'));
    }
}
