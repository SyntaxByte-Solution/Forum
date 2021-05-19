<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function store() {
        $this->authorize('create', Thread::class);

        $data = request()->validate([
            'subject'=>'required|min:2|max:1000',
            'category_id'=>'required|exists:categories,id'
        ]);

        $data['user_id'] = auth()->user()->id;

        Thread::create($data);
    }
}
