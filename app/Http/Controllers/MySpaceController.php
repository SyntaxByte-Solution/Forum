<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class MySpaceController extends Controller
{
    public function index(Request $request) {
        $pagesize = 5;
        $pagesize_exists = false;
        if($request->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = $request->input('pagesize');
        }

        $threads = Thread::where('user_id', auth()->user()->id)->paginate($pagesize);
        return view('myspace')
            ->with(compact('pagesize'))
            ->with(compact('pagesize_exists'))
            ->with(compact('threads'));
    }
}
