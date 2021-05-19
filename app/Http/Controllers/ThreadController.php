<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\DuplicateThreadException;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function store() {
        $this->authorize('store', Thread::class);

        if(auth()->user()->threads->where('subject', request()->subject)->count()) {
            throw new DuplicateThreadException();
        }

        $data = request()->validate([
            'subject'=>'required|min:2|max:1000',
            'category_id'=>'required|exists:categories,id'
        ]);

        $data['user_id'] = auth()->user()->id;

        Thread::create($data);
    }

    public function update(Thread $thread) {

        $this->authorize('update', $thread);
        /**
         * Notice here we need to verify if that user has already a thread with the submitted subject.
         * If so we need to reject the changes and tell that user that he has already a thread with that subject
         */
        if(auth()->user()->threads->where('subject', request()->subject)->count()) {
            throw new DuplicateThreadException();
        }

        $data = request()->validate([
            'subject'=>'sometimes|min:2|max:1000',
            'category_id'=>'sometimes|exists:categories,id'
        ]);

        $thread->update($data);
    }

    public function destroy(Thread $thread) {
        $this->authorize('destroy', $thread);

        $thread->delete();
    }
}
