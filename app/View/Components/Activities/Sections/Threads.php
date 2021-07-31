<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\{User, Thread, Category};

class Threads extends Component
{
    public $user;
    public $threads;

    public function __construct(User $user)
    {
        $this->user = $user;
        
        // Take 6 threads created by the current user (the profile owner - exclude announcements(later, we could add a global scope to exclude announcements))
        $announcements_ids = Category::where('slug', 'announcements')->pluck('id');
        $this->threads = Thread::whereNotIn('category_id', $announcements_ids)->where('user_id', $user->id)->orderBy('created_at', 'desc')->take(6)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.threads', $data);
    }
}
