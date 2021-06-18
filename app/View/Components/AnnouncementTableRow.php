<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Thread, User, Category, Forum};
use Carbon\Carbon;
use Markdown;

class AnnouncementTableRow extends Component
{
    public $thread_url;
    public $last_post_url;

    public $announcement_id;
    public $announcement_icon;
    public $announcement_title;
    public $views;
    public $thread_owner;
    public $thread_date;
    public $replies;
    public $at;

    public $last_post_content;
    public $last_post_owner_username;
    public $last_post_date;

    public $is_announcement;

    public function __construct(Thread $announcement)
    {
        $forum = Forum::find($announcement->category->forum_id)->slug;
        $category = Category::find($announcement->category_id);
        $this->announcement_icon = 'assets/images/icns/announcements.png';
        $this->announcement_id = $announcement->id;
        if(strlen($announcement->subject) > 60) {
            $this->announcement_title = substr($announcement->subject, 0, 60) . '..';
        } else {
            $this->announcement_title = $announcement->subject;
        }
        $this->at = (new Carbon($announcement->created_at))->toDayDateTimeString();
        $this->thread_date = (new Carbon($announcement->created_at))->toDayDateTimeString();
        $this->views = $announcement->view_count;
        $this->thread_owner = User::find($announcement->user_id)->username;
        $this->replies = $announcement->posts->count();

        $this->thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category->slug,'thread'=>$announcement->id]);
        
        $this->fetch_last_post($announcement);
    }

    private function fetch_last_post(Thread $thread) {
        $forum = Forum::find($thread->category->forum_id)->slug;
        $category = Category::find($thread->category_id);

        $last_post = $thread->posts->last();
        if($last_post) {
            $this->last_post_content = strlen(strip_tags(Markdown::parse($last_post->content))) > 60 ? strip_tags(Markdown::parse(substr($last_post->content, 0, 60))) . '..' : strip_tags(Markdown::parse($last_post->content));
            $this->last_post_owner_username = User::find($last_post->user_id)->username;
            $this->last_post_date = (new Carbon($last_post->created_at))->toDayDateTimeString();

            $this->last_post_url = route('thread.show', ['forum'=>$forum, 'category'=>$category->slug,'thread'=>$thread->id, '#' . $last_post->id]);
        } else {
            $this->thread_date = (new Carbon($thread->created_at))->toDayDateTimeString();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.thread.announcement');
    }
}
