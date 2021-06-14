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

        if($request->has('tab')) {
            $tab = $request->input('tab');
            if($tab == 'today') {
                $threads = Thread::today()->orderBy('created_at', 'desc')->paginate($pagesize);    
            } else if($tab == 'thisweek') {
                $threads = Thread::where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->paginate($pagesize);
            }
        } else {
            $threads = Thread::orderBy('created_at', 'desc')->paginate($pagesize);
        }

        $forums = Forum::all();
        $recent_threads = Thread::orderBy('created_at', 'desc')->take(4)->get();

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
