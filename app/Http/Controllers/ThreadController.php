<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\{DuplicateThreadException, CategoryClosedException};
use App\Models\{Forum, Thread, ThreadType, Category, CategoryStatus};
use App\Http\Controllers\PostController;

class ThreadController extends Controller
{
    public function show(Forum $forum, Thread $thread) {
        $forum_url = "/$forum->slug/discussions";
        $forum_name = $forum->forum;
        $thread_subject = $thread->subject;
        $posts = $thread->posts;

        return view('forum.discussion.show')
            ->with(compact('forum_name'))
            ->with(compact('forum_url'))
            ->with(compact('posts'))
            ->with(compact('thread_subject'));
    }

    public function create(Forum $forum) {
        $categories = $forum->categories;

        return view('discussion.create')
        ->with(compact('categories'));
    }

    public function store(Request $request) {
        $this->authorize('store', Thread::class);

        $data = request()->validate([
            'subject'=>'required|min:2|max:1000',
            'content'=>'required|min:2|max:40000',
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

        Thread::create($data);

        $forum_slug = Forum::find(Category::find($data['category_id'])->forum_id)->slug;
        $thread_type_slug = ThreadType::find($data['thread_type'])->slug;

        return redirect("/forum/$forum_slug/$thread_type_slug");
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
            'content'=>'sometimes|min:2|max:40000',
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
        $discussions = Thread::whereIn('category_id', $ids)->get();
        
        return view('forum.category.all-discussions')
        ->with(compact('discussions'));
    }
    public function all_questions(Forum $forum) {
        return view('forum.category.all-qestions');
    }
}
