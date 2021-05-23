<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\{DuplicateThreadException, CategoryClosedException};
use App\Models\{Thread, Category, CategoryStatus};

class ThreadController extends Controller
{
    public function store() {
        $this->authorize('store', Thread::class);

        $data = request()->validate([
            'subject'=>'required|min:2|max:1000',
            'category_id'=>'required|exists:categories,id'
        ]);

        if(auth()->user()->threads->where('subject', $data['subject'])->count()) {
            throw new DuplicateThreadException();
        }

        $category_status_slug = CategoryStatus::
                                    find(Category::find($data['category_id'])->status)
                                    ->slug;
        if($category_status_slug == 'closed') {
            throw new CategoryClosedException("You can't post a thread on a closed category");
        }
        if($category_status_slug == 'temp.closed') {
            throw new CategoryClosedException("You can't post a thread on a temporarily closed category");
        }

        $data['user_id'] = auth()->user()->id;

        return Thread::create($data);
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
