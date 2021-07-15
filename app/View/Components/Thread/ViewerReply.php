<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\Post;

class ViewerReply extends Component
{
    public $post;
    
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.thread.viewer-reply', $data);
    }
}
