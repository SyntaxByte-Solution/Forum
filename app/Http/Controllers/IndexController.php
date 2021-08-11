<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Forum, Thread, Category};

class IndexController extends Controller
{
    public function index(Request $request) {
        $pagesize = 8;
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
        $annc_ids = Category::where('slug', 'announcements')->pluck('id');
        $announcements = Thread::whereIn('category_id', $annc_ids)->take(4)->get();

        return view('index')
        ->with(compact('threads'))
        ->with(compact('announcements'))
        ->with(compact('pagesize'))
        ->with(compact('recent_threads'))
        ->with(compact('forums'));
    }

    public function forums() {
        $forums = Forum::all();
        $forum = Forum::first();
        $category = $forum->categories->where('slug', '<>', 'announcements')->first();
        $recent_threads = Thread::
            orderBy('created_at', 'desc')->take(6)->get();

        return view('forums')
        ->with(compact('recent_threads'))
        ->with(compact('forums'))
        ->with(compact('category'))
        ->with(compact('forum'));
    }
}
