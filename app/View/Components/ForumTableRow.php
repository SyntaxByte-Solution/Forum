<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Forum, Category, Post, Thread, User};

class ForumTableRow extends Component
{
    public $forum;
    public $forum_icon;
    public $forum_slug;
    public $forum_forum;
    public $forum_description;

    public $threads_count;
    public $posts_count;

    public $last_thread_title;
    public $last_thread_owner_username;
    public $last_thread_date;
    public $last_thread_link;

    public function __construct(Forum $forum)
    {
        $this->forum = $forum;
        $this->forum_slug = $forum->slug;
        $this->forum_forum = $forum->forum;
        $this->forum_description = $forum->description;
        $this->all_threads_count($forum);

        $this->fetch_last_thread($forum);
    }

    private function fetch_last_thread($forum) {
        $categories = $forum->categories->pluck('id');
        $last_thread = Thread::whereIn('category_id', $categories)->orderBy('created_at', 'desc')->first();

        if($last_thread) {
            $category = Category::find($last_thread->category_id);
            $this->last_thread_title = strlen($last_thread->subject) > 80 ? substr($last_thread->subject, 0, 80) : $last_thread->subject;
            $this->last_thread_owner_username = User::find($last_thread->user_id)->username;
            $this->last_thread_date = $last_thread->created_at;
        }
    }

    private function all_threads_count($forum) {
        $threads_count = 0;
        $posts_count = 0;

        foreach($forum->categories as $category) {
            $threads_count += $category->threads->count();
            foreach($category->threads as $thread) {
                $posts_count += $thread->posts->count();
            }
        }

        $this->threads_count = $threads_count;
        $this->posts_count = $posts_count;
    }

    public function render()
    {
        return view('components.forum-table-row');
    }
}
