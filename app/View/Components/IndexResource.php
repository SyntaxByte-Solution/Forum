<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\{Thread, User, Category, Forum, Follow};
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Markdown;
use FFMpeg;


class IndexResource extends Component
{
    
    public $thread;
    public $type;
    public $typestring;
    public $owner;
    public $forum;
    public $category;
    public $content;
    // in case the thread is poll
    public $options;
    public $multiple_choice;
    public $allow_options_creation;
    
    public $edit_link;
    public $category_threads_link;

    public $followed;
    public $saved;
    public $views;
    public $likes;
    public $liked;
    public $replies;
    public $at;
    public $at_hummans;

    public $medias;

    public function __construct(Thread $thread) {
        $this->thread = $thread;
        $this->type = $thread->type;
        $this->owner = $thread->user;
        $this->forum = $thread->category->forum;
        $this->category = $thread->category;
        $this->at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->at_hummans = (new Carbon($thread->created_at))->diffForHumans();
        $this->views = $thread->view_count;
        $this->replies = $thread->posts()->count();
        if($thread->type == 'poll') {
            $this->typestring = 'poll';
            $poll = $thread->poll;
            $this->options = $poll->options()->withCount('votes as votes')->orderBy('votes', 'desc')->get();
            $this->multiple_choice = (bool)$poll->allow_multiple_choice;
            $this->allow_options_creation = (bool)$poll->allow_choice_add;
        } else
            $this->typestring = 'discussion';
            
        
        $likemanager = $thread->likedandlikescount;
        $this->likes = $likemanager['count'];
        $this->liked = $likemanager['liked'];
        $this->content = Str::markdown($thread->content);

        if(Auth::check() && Auth::user()->id != $thread->id) {
            $this->followed = 
                in_array($thread->user->id, \DB::table('follows') // This query get followers ids as array
                ->select('followable_id')
                ->where('follower', auth()->user()->id)
                ->pluck('followable_id')->toArray());

            $this->saved = auth()->user()->isthatthreadsaved($thread);
        } else
            $this->followed = false;

        $this->edit_link = route('thread.edit', ['user'=>$thread->user->username, 'thread'=>$thread->id]);
        $this->category_threads_link = route('category.threads', ['forum'=>$this->forum->slug, 'category'=>$this->category->slug]);

        // Thread medias
        if($thread->has_media) {
            $medias_links = 
                Storage::disk('public')->files('users/' . $thread->user->id . '/threads/' . $thread->id . '/medias');

            $medias = [];
            foreach($medias_links as $media) {
                $media_type = 'image';
                $media_source = $media;
                $mime = mime_content_type($media);
                if(strstr($mime, "video/")){
                    $media_type = 'video';
                }else if(strstr($mime, "image/")){
                    $media_source = $media;
                }

                $medias[] = ['frame'=>$media_source, 'type'=>$media_type, 'mime'=>$mime];
            }
            $this->medias = $medias;
        }
    }
        
    function convert($number)
    {
        if($number < 1000) return $number;
        $suffix = ['','k','M','G','T','P','E','Z','Y'];
        $power = floor(log($number, 1000));
        return round($number/(1000**$power),1,PHP_ROUND_HALF_EVEN).$suffix[$power];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.thread.index-resource', $data);
    }
}
