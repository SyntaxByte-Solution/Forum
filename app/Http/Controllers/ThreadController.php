<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as Rqst;
use App\Exceptions\{DuplicateThreadException, CategoryClosedException};
use App\Models\{Forum, Thread, ThreadType, Category, CategoryStatus, User};
use App\Http\Controllers\PostController;

class ThreadController extends Controller
{
    public function show(Forum $forum, Category $category, Thread $thread) {
        $thread_owner = User::find($thread->user_id);

        $thread_subject = strlen($thread->subject) > 60 ? substr($thread->subject, 0, 60) : $thread->subject;
        $posts = $thread->posts;

        return view('forum.thread.show')
            ->with(compact('forum'))
            ->with(compact('category'))
            ->with(compact('thread'))
            ->with(compact('thread_subject'))
            ->with(compact('posts'))
            ->with(compact('thread_owner'));
    }

    public function create(Forum $forum, Category $category) {
        $this->authorize('create', Thread::class);

        $forums = Forum::where('id', '<>', $forum->id)->get();
        $categories = $forum->categories->where('slug', '<>', 'announcements');

        return view('forum.thread.create')
            ->with(compact('forums'))
            ->with(compact('forum'))
            ->with(compact('category'))
            ->with(compact('categories'));
    }

    public function store(Request $request) {
        $this->authorize('store', Thread::class);

        $data = request()->validate([
            'subject'=>'required|min:2|max:1000',
            'content'=>'required|min:2|max:40000',
            'category_id'=>'required|exists:categories,id',
            'content'=>'required|min:2|max:40000',
        ]);

        $duplicated_thread;        
        $duplicated_thread_url;        
        try {

            /**
             * User could not have two threads with the same subject in the same category
             */
            if(auth()->user()->threads
                ->where('subject', $data['subject'])
                ->where('category_id', $data['category_id'])->count()) {

                $duplicated_thread = auth()->user()->threads
                ->where('subject', $data['subject'])
                ->where('category_id', $data['category_id'])->first();
                throw new DuplicateThreadException();
            }
        } catch(DuplicateThreadException $exception) {
            \Session::flash('type', 'error');
            /**
             * If there's a duplicate subjects in the same category we need to 
             * reload the page by passing flash message to inform the user
             */ 
            $forum = Forum::find(Category::find($data['category_id'])->forum_id)->slug;
            $category = Category::find($data['category_id'])->slug;

            $duplicate_thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicated_thread->id]);
            \Session::flash('message', "This title is already exists in your threads list(<a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>click here</a>), please choose another one !");
            return redirect()->back();
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

        $forum_slug = Forum::find(Category::find($data['category_id'])->forum_id)->slug;
        $categaory_slug = Category::find($data['category_id'])->slug;

        return redirect(route('thread.show', ['forum'=>$forum_slug, 'category'=>$categaory_slug, 'thread'=>$thread->id]));
    }

    public function edit(User $user, Thread $thread) {
        $this->authorize('edit', $thread);

        $category = Category::find($thread->category_id);
        $forum = Forum::find($category->forum_id);
        $forums = Forum::where('id', '<>', $forum->id)->get();
        $categories = $forum->categories->where('slug', '<>', 'announcements');

        return view('forum.thread.edit')
            ->with(compact('forums'))
            ->with(compact('forum'))
            ->with(compact('category'))
            ->with(compact('categories'))
            ->with(compact('thread'));
    }

    public function update(Thread $thread) {

        $this->authorize('update', $thread);

        $forum = Forum::find(Category::find($thread->category_id)->forum_id)->slug;
        $category = Category::find($thread->category_id)->slug;
        $duplicated_thread;
        /**
         * Notice here we need to verify if that user has already a thread with the submitted subject.
         * If so we need to reject the changes and tell that user that he has already a thread with that subject
         */
        try {

            /**
             * User could not update the thread with a subject that already exists
             * in the same category
             */
            if(auth()->user()->threads
                ->where('subject', request()->subject)
                ->where('category_id', request()->category_id)
                ->where('id', '<>', $thread->id)->count()) {
                $duplicated_thread = auth()->user()->threads
                    ->where('subject', request()->subject)
                    ->where('category_id', request()->category_id)
                    ->where('id', '<>', $thread->id)->first();
                throw new DuplicateThreadException();
            }
        } catch(DuplicateThreadException $exception) {
            \Session::flash('type', 'error');
            /**
             * If there's a duplicate subjects in the same category we need to 
             * reload the page by passing flash message to inform the user
             */ 
            $duplicate_thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicated_thread->id]);
            \Session::flash('message', "This title is already exists in your thread list withing the same category(<a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>click here</a>), please choose another one !");
            return route('thread.edit', ['user'=>auth()->user()->username, 'thread'=>$thread->id]);
        }

        $data = request()->validate([
            'subject'=>'sometimes|min:2|max:1000',
            'content'=>'sometimes|min:2|max:40000',
            'category_id'=>'sometimes|exists:categories,id',
        ]);

        $thread->update($data);

        $forum_slug = Forum::find(Category::find($data['category_id'])->forum_id)->slug;

        return route('thread.show', ['forum'=>$forum_slug, 'category'=>$category, 'thread'=>$thread->id]);
    }

    public function delete(Thread $thread) {
        $this->authorize('delete', $thread);

        $forum_slug = Forum::find(Category::find($thread['category_id'])->forum_id)->slug;

        /**
         * Notice here we don't have to delete the related resource because we used soft
         * deleting so the user could restore the post later. But we need to clean up when the
         * use choose to permanently delete the thread !
         */

        $thread->delete();
        return redirect(route('user.activities', ['user'=>auth()->user()->username]));
    }

    public function destroy(Thread $thread) {
        $this->authorize('destroy', $thread);

        $forum_slug = Forum::find(Category::find($thread['category_id'])->forum_id)->slug;

        $thread->forceDelete();
        return redirect(route('user.activities', ['user'=>auth()->user()->username]));
    }

    public function forum_all_threads(Forum $forum) {
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $category = $forum->categories->first();
        $forums = Forum::where('id', '<>', $forum->id)->get();

        // First get all forum's categories
        $categories_ids = $categories->pluck('id');

        // Fetching announcements
        $anoun_id = Category::where('slug', 'announcements')->where('forum_id', $forum->id)->first()->id;
        $announcements = Thread::where('category_id', $anoun_id)->get();

        $pagesize = 10;
        $pagesize_exists = false;
        
        if(request()->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = request()->input('pagesize');
        }

        // Then we fetch all threads in those categories
        $threads = Thread::whereIn('category_id', $categories_ids)->orderBy('created_at', 'desc')->paginate($pagesize);
        
        return view('forum.category.categories-threads')
        ->with(compact('forums'))
        ->with(compact('categories'))
        ->with(compact('category'))
        ->with(compact('announcements'))
        ->with(compact('threads'))
        ->with(compact('pagesize'));
    }

    public function category_threads(Forum $forum, Category $category) {
        $category = $category;
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $forums = Forum::where('id', '<>', $forum->id)->get();

        $pagesize = 10;
        $pagesize_exists = false;
        
        if(request()->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = request()->input('pagesize');
        }

        $threads = Thread::where('category_id', $category->id)->orderBy('created_at', 'desc')->paginate($pagesize);

        return view('forum.category.category-threads')
        ->with(compact('forums'))
        ->with(compact('category'))
        ->with(compact('categories'))
        ->with(compact('threads'))
        ->with(compact('pagesize'));
    }
}
