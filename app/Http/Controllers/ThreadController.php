<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\{DuplicateThreadException, CategoryClosedException};
use App\Models\{Forum, Thread, Category, CategoryStatus};
use App\Http\Controllers\PostController;

class ThreadController extends Controller
{
    public function create(Forum $forum) {
        $categories = $forum->categories;

        return view('discussion.create')
        ->with(compact('categories'));
    }

    public function store() {
        $this->authorize('store', Thread::class);

        $data = request()->validate([
            'subject'=>'required|min:2|max:1000',
            'category_id'=>'required|exists:categories,id',
            'thread_type'=>'required|exists:thread_types,id',
            'content'=>'required|min:2|max:40000',
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

        $thread = Thread::create($data);
        request()->request->add(['thread_id'=>$thread->id]);
        (new PostController)->store();

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
            'category_id'=>'sometimes|exists:categories,id',
            'thread_type'=>'sometimes|exists:thread_types,id',
        ]);

        $thread->update($data);
    }

    public function destroy(Thread $thread) {
        $this->authorize('destroy', $thread);

        $thread->delete();
    }

    public function all_discussions(Forum $forum) {
        // First get all forum's categories
        $ids = $forum->categories->pluck('id');
        // Then we fetch all threads in those categories
        $discussions = Thread::whereIn('category_id', $ids);
        
        return view('forum.category.all-discussions')
        ->with(compact('discussions'));
    }
    public function all_questions(Forum $forum) {
        return view('forum.category.all-qestions');
    }
}
