<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Forum, Thread};

class IndexController extends Controller
{
    public function index(Request $request) {
        $pagesize = 10;
        $pagesize_exists = false;
        if($request->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = $request->input('pagesize');
        }

        $threads = Thread::orderBy('created_at', 'desc')->paginate($pagesize);

        $forums = Forum::all();
        $recent_threads = Thread::orderBy('created_at', 'desc')->take(6)->get();

        return view('index')
        ->with(compact('threads'))
        ->with(compact('pagesize'))
        ->with(compact('recent_threads'))
        ->with(compact('forums'));
    }

    public function forums() {
        $forums = Forum::all();
        $recent_threads = Thread::
        orderBy('created_at', 'desc')->take(6)->get();

        return view('forums')
        ->with(compact('recent_threads'))
        ->with(compact('forums'));
    }
}
