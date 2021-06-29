<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Thread, User, Category, Forum};
use Carbon\Carbon;
use Markdown;

class Announcement extends Component
{
    public $last_post_url;

    public $announcement;
    public $owner;
    public $announcement_icon;
    public $views;
    public $forum_name;
    public $forum_link;
    public $thread_date;
    public $replies;
    public $at;

    public $last_post_content;
    public $last_post_owner_username;
    public $last_post_date;

    public function __construct(Thread $announcement)
    {
        $this->announcement = $announcement;
        $this->owner = $announcement->user;
        $this->forum_name = $announcement->forum()->forum;
        $this->forum_link = route('forum.all.threads', ['forum'=>$announcement->forum()->slug]);
        $this->announcement_icon = 'assets/images/icns/announcements.png';
        $this->at = (new Carbon($announcement->created_at))->toDayDateTimeString();
        $this->thread_date = (new Carbon($announcement->created_at))->toDayDateTimeString();
        $this->views = $announcement->view_count;
        
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
