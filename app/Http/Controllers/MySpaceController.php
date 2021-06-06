<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Thread, Category};

class MySpaceController extends Controller
{
    public function index(Request $request) {
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
                ->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')->lazy();
        } else {
            $threads = Thread::whereNotIn('category_id', $announcements)->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate($pagesize);
        }
        return view('myspace')
            ->with(compact('pagesize'))
            ->with(compact('pagesize_exists'))
            ->with(compact('all'))
            ->with(compact('threads'));
    }
}
