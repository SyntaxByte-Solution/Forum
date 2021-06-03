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
        $forum_slug = $forum->slug;
        $forum_name = $forum->forum;

        $category_name = $category->category;
        $category_slug = $category->slug;

        $thread_subject = strlen($thread->subject) > 60 ? substr($thread->subject, 0, 60) : $thread->subject;
        $posts = $thread->posts;

        if($thread->thread_type == 1) {
            return view('forum.discussion.show')
                ->with(compact('forum_name'))
                ->with(compact('forum_slug'))
                ->with(compact('category_name'))
                ->with(compact('category_slug'))
                ->with(compact('posts'))
                ->with(compact('thread_subject'));
            } else if($thread->thread_type == 2) {
            return view('forum.question.show')
                ->with(compact('forum_name'))
                ->with(compact('forum_slug'))
                ->with(compact('category_name'))
                ->with(compact('category_slug'))
                ->with(compact('posts'))
                ->with(compact('thread_subject'));
        }
    }

    public function create(Forum $forum) {
        $this->authorize('create', Thread::class);

        $forums = Forum::where('id', '<>', $forum->id)->get();
        $categories = $forum->categories->where('slug', '<>', 'announcements');
        $view = '';
        if(strpos(url()->current(), 'discussions')) {
            $view = 'forum.discussion.create';
        } else if(strpos(url()->current(), 'questions')) {
            $view = 'forum.question.create';
        }

        return view($view)
            ->with(compact('forums'))
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

        $duplicated_thread;        
        $duplicated_thread_url;        
        try {

            /**
             * Notice that here we need to manage a special situation
             * two threads could have the same subject(title) but they 
             * have to have different thread_type or same thread_type but different category
             */
            if(auth()->user()->threads
                ->where('subject', $data['subject'])
                ->where('thread_type', $data['thread_type'])
                ->where('category_id', $data['category_id'])->count()) {

                $duplicated_thread = auth()->user()->threads
                ->where('subject', $data['subject'])
                ->where('thread_type', $data['thread_type'])
                ->where('category_id', $data['category_id'])->first();
                throw new DuplicateThreadException();
            }
        } catch(DuplicateThreadException $exception) {
            \Session::flash('type', 'error');
            /**
             * If the edited thread is a discussion and there's a duplicate subjects we need to 
             * reload the page by passing flash message to inform the user
             */ 
            $forum = Forum::find(Category::find($data['category_id'])->forum_id)->slug;
            $category = Category::find($data['category_id'])->slug;

            if(request()->thread_type == 1) {
                $duplicate_thread_url = route('discussion.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicated_thread->id]);
                \Session::flash('message', "This title is already exists in your thread list(<a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>click here</a>), please choose another one !");
                return redirect()->back();
            } else if(request()->thread_type == 2) {
                $duplicate_thread_url = route('question.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicated_thread->id]);
                \Session::flash('message', "This question subject is already exists in your questions list(<a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>click here</a>), please choose another one !");
                return redirect()->back();
            }
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

        if($data['thread_type'] == 1) {
            return redirect(route('get.all.forum.discussions', [$forum_slug]));
        } else if($data['thread_type'] == 2) {
            return redirect(route('get.all.forum.questions', [$forum_slug]));
        }
    }

    public function edit(User $user, Thread $thread) {
        $this->authorize('edit', $thread);

        $category = Category::find($thread->category_id);
        $forum = Forum::find($category->forum_id);
        $forums = Forum::where('id', '<>', $forum->id)->get();
        $categories = $forum->categories->where('slug', '<>', 'announcements');

        $view = '';
        if($thread->thread_type == 1) {
            $view = 'forum.discussion.edit';
        } else if($thread->thread_type == 2) {
            $view = 'forum.question.edit';
        }

        return view($view)
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
             * Notice that here we need to manage a special situation
             * two threads could have the same subject(title) but they 
             * have to have different thread_type or same thread_type but different category
             */
            if(auth()->user()->threads
                ->where('subject', request()->subject)
                ->where('thread_type', request()->thread_type)
                ->where('category_id', request()->category_id)
                ->where('id', '<>', $thread->id)->count()) {
                $duplicated_thread = auth()->user()->threads
                    ->where('subject', request()->subject)
                    ->where('thread_type', request()->thread_type)
                    ->where('category_id', request()->category_id)
                    ->where('id', '<>', $thread->id)->first();
                throw new DuplicateThreadException();
            }
        } catch(DuplicateThreadException $exception) {
            \Session::flash('type', 'error');
            /**
             * If the edited thread is a discussion and there's a duplicate subjects we need to 
             * reload the page by passing flash message to inform the user
             */ 
            if(request()->thread_type == 1) {
                $duplicate_thread_url = route('discussion.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicated_thread->id]);
                \Session::flash('message', "This title is already exists in your thread list(<a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>click here</a>), please choose another one !");
                return route('discussion.edit', ['user'=>auth()->user()->username, 'thread'=>$thread->id]);
            } else if(request()->thread_type == 2) {
                $duplicate_thread_url = route('question.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicated_thread->id]);
                \Session::flash('message', "This title is already exists in your thread list(<a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>click here</a>), please choose another one !");
                return route('question.edit', ['user'=>auth()->user()->username, 'thread'=>$thread->id]);
            }
        }

        $data = request()->validate([
            'subject'=>'sometimes|min:2|max:1000',
            'content'=>'sometimes|min:2|max:40000',
            'category_id'=>'sometimes|exists:categories,id',
            'thread_type'=>'sometimes|exists:thread_types,id',
        ]);

        $thread->update($data);

        $forum_slug = Forum::find(Category::find($data['category_id'])->forum_id)->slug;

        if($data['thread_type'] == 1) {
            return route('discussion.show', ['forum'=>$forum_slug, 'category'=>$category, 'thread'=>$thread->id]);
        } else if($data['thread_type'] == 2) {
            return route('question.show', ['forum'=>$forum_slug, 'category'=>$category, 'thread'=>$thread->id]);
        }
    }

    public function delete(Thread $thread) {
        $this->authorize('delete', $thread);

        $forum_slug = Forum::find(Category::find($thread['category_id'])->forum_id)->slug;

        if($thread->thread_type == 1) {
            $url = route('get.all.forum.discussions', [$forum_slug]);
        } else if($thread->thread_type == 2) {
            $url = route('get.all.forum.questions', [$forum_slug]);
        }

        /**
         * Before deleting the thread, we need to clear all posts related to this thread
         */
        // foreach($thread->posts as $post) {
        //     $post->delete();
        // }

        $thread->delete();
        return redirect($url);
    }

    public function destroy(Thread $thread) {
        $this->authorize('destroy', $thread);

        $forum_slug = Forum::find(Category::find($thread['category_id'])->forum_id)->slug;

        if($thread->thread_type == 1) {
            $url = route('get.all.forum.discussions', [$forum_slug]);
        } else if($thread->thread_type == 2) {
            $url = route('get.all.forum.questions', [$forum_slug]);
        }

        /**
         * Before deleting the thread, we need to clear all posts related to this thread
         */
        // foreach($thread->posts as $post) {
        //     $post->delete();
        // }

        $thread->forceDelete();
        return redirect($url);
    }

    public function all_discussions(Forum $forum) {
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $forums = Forum::where('id', '<>', $forum->id)->get();
        $anoun_id = Category::where('slug', 'announcements')->where('forum_id', $forum->id)->first()->id;
        $announcements = Thread::where('category_id', $anoun_id)->where('thread_type', 1)->get();

        // First get all forum's categories
        $ids = $categories->pluck('id');
        // Then we fetch all threads in those categories
        $discussions = Thread::whereIn('category_id', $ids)->where('thread_type', 1)->get();
        
        return view('forum.discussion.all-discussions')
        ->with(compact('categories'))
        ->with(compact('forums'))
        ->with(compact('announcements'))
        ->with(compact('discussions'));
    }
    public function all_questions(Forum $forum) {
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $forums = Forum::where('id', '<>', $forum->id)->get();
        $anoun_id = Category::where('slug', 'announcements')->where('forum_id', $forum->id)->first()->id;
        $announcements = Thread::where('category_id', $anoun_id)->where('thread_type', 1)->get();

        // First get all forum's categories
        $ids = $categories->pluck('id');
        // Then we fetch all threads in those categories
        $questions = Thread::whereIn('category_id', $ids)->where('thread_type', 2)->get();
        
        return view('forum.question.all-questions')
        ->with(compact('categories'))
        ->with(compact('forums'))
        ->with(compact('announcements'))
        ->with(compact('questions'));
    }
    public function forum_all_threads(Forum $forum) {
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $forums = Forum::where('id', '<>', $forum->id)->get();

        // First get all forum's categories
        $ids = $categories->pluck('id');
        // Then we fetch all threads in those categories
        $threads = Thread::whereIn('category_id', $ids)->orderBy('created_at', 'desc')->get();
        $anoun_id = Category::where('slug', 'announcements')->where('forum_id', $forum->id)->first();
        $anoun_id = $anoun_id->id;
        $announcements = Thread::where('category_id', $anoun_id)->get();
        
        return view('forum.category.misc')
        ->with(compact('forums'))
        ->with(compact('categories'))
        ->with(compact('announcements'))
        ->with(compact('threads'));
    }

    public function category_misc(Forum $forum, Category $category) {
        $category = $category;
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $threads = Thread::where('category_id', $category->id)->get();
        $forums = Forum::where('id', '<>', $forum->id)->get();

        return view('forum.category.category-misc')
        ->with(compact('forums'))
        ->with(compact('category'))
        ->with(compact('categories'))
        ->with(compact('threads'));
    }

    public function category_discussions(Forum $forum, Category $category) {
        $forums = Forum::where('id', '<>', $forum->id)->get();
        $category = $category;
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $threads = Thread::where('category_id', $category->id)->where('thread_type', 1)->get();

        return view('forum.category.category-discussions')
        ->with(compact('forums'))
        ->with(compact('category'))
        ->with(compact('categories'))
        ->with(compact('threads'));
    }

    public function category_questions(Forum $forum, Category $category) {
        $forums = Forum::where('id', '<>', $forum->id)->get();
        $category = $category;
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $threads = Thread::where('category_id', $category->id)->where('thread_type', 2)->get();

        return view('forum.category.category-questions')
        ->with(compact('forums'))
        ->with(compact('category'))
        ->with(compact('categories'))
        ->with(compact('threads'));
    }
}
