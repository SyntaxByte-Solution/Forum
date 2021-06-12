<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;

class IndexController extends Controller
{
    public function index() {
        $forums = Forum::all();
        return view('index')
        ->with(compact('forums'));
    }

    public function forums() {
        $forums = Forum::all();
        return view('forums')
        ->with(compact('forums'));
    }
}
