<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Thread, User, Category, Forum};
use Carbon\Carbon;
use Markdown;

class DiscussionTableRow extends Component
{
    public $thread_url;
    public $last_post_url;

    public $discussion_id;
    public $discussion_icon;
    public $discussion_title;
    public $views;
    public $thread_owner;
    public $thread_date;
    public $replies;
    public $at;

    public $last_post_content;
    public $last_post_owner_username;
    public $last_post_date;

    public $is_announcement;

    public function __construct(Thread $discussion)
    {
        $forum = Forum::find($discussion->category->forum_id)->slug;
        $category = Category::find($discussion->category_id);
        
        if($category->slug == 'announcements') {
            $this->discussion_icon = 'assets/images/icns/announcements.png';
            $this->is_announcement = true;
        } else {
            $this->discussion_icon = 'assets/images/icns/discussions.png';
            $this->is_announcement = false;
        }

        $this->discussion_id = $discussion->id;
        if(strlen($discussion->subject) > 60) {
            $this->discussion_title = substr($discussion->subject, 0, 60) . '..';
        } else {
            $this->discussion_title = $discussion->subject;
        }
        $this->at = (new Carbon($discussion->created_at))->toDayDateTimeString();
        $this->thread_date = (new Carbon($discussion->created_at))->toDayDateTimeString();
        $this->views = $discussion->view_count;
        $this->thread_owner = User::find($discussion->user_id)->username;
        $this->replies = $discussion->posts->count();

        if($discussion->thread_type == 1) {
            $this->thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category->slug,'thread'=>$discussion->id]);
        } else if($discussion->thread_type == 2) {
            $this->thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category->slug, 'thread'=>$discussion->id]);
        }

        $this->fetch_last_post($discussion);
    }

    private function fetch_last_post(Thread $thread) {
        $forum = Forum::find($thread->category->forum_id)->slug;
        $category = Category::find($thread->category_id);

        $last_post = $thread->posts->last();
        if($last_post) {
            $this->last_post_content = strlen(strip_tags(Markdown::parse($last_post->content))) > 60 ? strip_tags(Markdown::parse(substr($last_post->content, 0, 60))) . '..' : strip_tags(Markdown::parse($last_post->content));
            $this->last_post_owner_username = User::find($last_post->user_id)->username;
            $this->last_post_date = (new Carbon($last_post->created_at))->toDayDateTimeString();

            if($thread->thread_type == 1) {
                $this->last_post_url = route('thread.show', ['forum'=>$forum, 'category'=>$category->slug,'thread'=>$thread->id, '#' . $last_post->id]);
            } else if($thread->thread_type == 2) {
                $this->last_post_url = route('thread.show', ['forum'=>$forum, 'category'=>$category->slug, 'thread'=>$thread->id, '#' . $last_post->id]);
            }
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
        return view('components.discussion.discussion-table-row');
    }
}
