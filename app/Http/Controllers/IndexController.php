<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Forum, Thread, Category};
use App\View\Components\IndexResource;
use Carbon\Carbon;

class IndexController extends Controller
{
    const PAGESIZE = 8;
    const FETCH_PAGESIZE = 6;

    public function index(Request $request) {
        $tab_title = 'All'; // By default is all, until the user choose other option
        $tab = "all";
        $pagesize = self::PAGESIZE;
        if($request->has('tab')) {
            $tab = $request->input('tab');
            if($tab == 'today') {
                $threads = Thread::today()->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->paginate($pagesize);
                $tab_title = 'Today';
            } else if($tab == 'thisweek') {
                $threads = Thread::where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->paginate($pagesize);
                $tab_title = 'This week';
            }
        } else {
            $threads = Thread::orderBy('created_at', 'desc')->paginate($pagesize);
        }
        
        $forums = Forum::all();
        $recent_threads = Thread::orderBy('created_at', 'desc')->take(4)->get();

        return view('index')
        ->with(compact('threads'))
        ->with(compact('tab'))
        ->with(compact('tab_title'))
        ->with(compact('pagesize'))
        ->with(compact('recent_threads'))
        ->with(compact('forums'));
    }

    public function index_load_more(Request $request) {
        $indexes = $request->validate([
            'skip'=>'required|numeric|max:600',
            'tab'=>[
                'required',
                Rule::in(['all', 'today', 'thisweek']),
            ]
        ]);
        
        switch($indexes['tab']) {
            case 'all':
                $threads = Thread::orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE)->get();
                break;
            case 'today':
                $threads = Thread::today()->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE)->get();
                break;
            case 'thisweek':
                $threads = Thread::where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE)->get();
                break;
        }

        $payload = "";
        foreach($threads as $thread) {
            $thread_component = (new IndexResource($thread));
            $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
            $payload .= $thread_component;
        }

        return [
            "content"=>$payload,
            'count'=>$threads->count(),
        ];
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

    public function announcements() {
        $announcement_ids = Category::where('slug', 'announcements')->pluck('id');
        $announcements = Thread::whereIn('category_id', $announcement_ids)->paginate(5);
        return view('announcements')
        ->with(compact('announcements'));
    }

    public function guidelines() {
        return view('guidelines');
    }

    public function about() {
        return view('aboutus');
    }
}
