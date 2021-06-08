<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Thread, Category, User};

class UserController extends Controller
{
    public function activities(Request $request, User $user) {
        $pagesize = 10;
        $pagesize_exists = false;
        $all = false;
        if($request->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = $request->input('pagesize');
        }

        $announcements = Category::where('slug', 'announcements')->pluck('id');

        $threads;
        if($pagesize == 'all') {
            $all = true;
            $threads = Thread::whereNotIn('category_id', $announcements)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')->lazy();
        } else {
            $threads = Thread::whereNotIn('category_id', $announcements)->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate($pagesize);
        }

        $discussions_count = $user->discussions_count();
        $questions_count = $user->questions_count();
        $posts_count = $user->posts_count();

        return view('user.activities')
            ->with(compact('user'))
            ->with(compact('discussions_count'))
            ->with(compact('questions_count'))
            ->with(compact('posts_count'))
            ->with(compact('pagesize'))
            ->with(compact('pagesize_exists'))
            ->with(compact('all'))
            ->with(compact('threads'));
    }

    public function profile(Request $request, User $user) {
        $discussions_count = $user->discussions_count();
        $questions_count = $user->questions_count();
        $posts_count = $user->posts_count();

        $recent_threads = $user->threads()
        ->orderBy('created_at', 'desc')->paginate(6);

        return view('user.profile')
            ->with(compact('user'))
            ->with(compact('discussions_count'))
            ->with(compact('questions_count'))
            ->with(compact('posts_count'))
            ->with(compact('recent_threads'));
    }

    public function settings(Request $request, User $user) {
        $firstname = $user->firstname;
        $lastname = $user->lastname;
        $username = $user->username;

        return view('user.settings.settings')
            ->with(compact('firstname'))
            ->with(compact('lastname'))
            ->with(compact('username'))
            ->with(compact('user'));
    }
}
