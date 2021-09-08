<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Forum, Thread};
use App\View\Components\IndexResource;
use App\Scopes\{ExcludeAnnouncements, FollowersOnlyScope};
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
            $tab = $request->get('tab');
            if($tab == 'today') {
                $threads = Thread::today()->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->take(self::PAGESIZE+1)->get();
                $tab_title = 'Today';
            } else if($tab == 'thisweek') {
                $threads = Thread::where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->take(self::PAGESIZE+1)->get();
                $tab_title = 'This week';
            }
        } else {
            $threads = Thread::orderBy('created_at', 'desc')->take(self::PAGESIZE+1)->get();
        }

        $hasmore = false;
        if($threads->count() > self::PAGESIZE) {
            $hasmore = true;
            $threads =$threads->take(self::PAGESIZE);
        }

        return view('index')
        ->with(compact('hasmore'))
        ->with(compact('threads'))
        ->with(compact('tab'))
        ->with(compact('tab_title'))
        ->with(compact('pagesize'));
    }

    public function forums() {
        $forums = Forum::all();
        
        return view('forums')
            ->with(compact('forums'));
    }
    
    public function announcements() {
        $announcements = Thread::
            withoutGlobalScope(ExcludeAnnouncements::class)
            ->withoutGlobalScope(FollowersOnlyScope::class)
            ->whereHas('category', function($query) {
                $query->where('slug', 'announcements');
            })->paginate(4);

        return view('announcements')
        ->with(compact('announcements'));
    }
    public function guidelines() {
        return view('guidelines');
    }
    public function about() {
        return view('aboutus');
    }
    public function privacy() {
        return view('privacy-policy');
    }
}
