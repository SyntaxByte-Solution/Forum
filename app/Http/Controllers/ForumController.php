<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Exceptions\UnauthorizedActionException;
use Illuminate\Http\Request;
use App\Models\Forum;

class ForumController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store() {
        if (! Gate::allows('add.forum')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }

        $data = request()->validate([
            'forum'=>'min:2|max:180|unique:forums,forum',
            'slug'=>'min:2|max:180|unique:forums,slug',
            'description'=>'max:2000|nullable',
            'status'=>'exists:forum_status,id',
        ]);

        Forum::create($data);
    }

    public function update(Forum $forum) {
        if (! Gate::allows('update.forum')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }

        $data = request()->validate([
            'forum'=>'sometimes|min:2|max:180|unique:forums,forum',
            'slug'=>'sometimes|min:2|max:180|unique:forums,slug',
            'description'=>'sometimes|max:2000|nullable',
            'status'=>'sometimes|exists:forum_status,id',
        ]);

        $forum->update($data);
    }

    public function destroy(Forum $forum) {
        if (! Gate::allows('delete.forum')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }

        $forum->delete();
    }
}