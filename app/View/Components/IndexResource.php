<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{Thread, User, Category, Forum, Follow};
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Markdown;
use FFMpeg;


class IndexResource extends Component
{
    
    public $thread;
    public $forum;
    public $category;
    public $content;
    
    public $edit_link;
    public $category_threads_link;

    public $followed;
    public $views;
    public $likes;
    public $replies;
    public $at;
    public $at_hummans;

    public $medias;

    public function __construct(Thread $thread) {
        $this->thread = $thread;
        $this->forum = Forum::find($thread->category->forum_id);
        $this->category = Category::find($thread->category_id);
        $forum = $this->forum->slug;

        $this->at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->at_hummans = (new Carbon($thread->created_at))->diffForHumans();
        $this->views = $thread->view_count;
        $this->replies = $thread->posts->count();
        $this->likes = $thread->likes->count();
        $this->content = Markdown::parse($thread->content);

        if(Auth::check()) {
            $this->followed = Follow::where('follower', auth()->user()->id)
            ->where('followable_id', $thread->user->id)
            ->where('followable_type', 'App\Models\User')
            ->count() > 0;
        } else {
            $this->followed = false;
        }

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
