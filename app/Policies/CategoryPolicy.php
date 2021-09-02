<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Forum, Category};

class CategoryPolicy
{
    use HandlesAuthorization;

    public function store(User $user, $fid, $slug) {
        $forum = Forum::find($fid);
        /**
         * category is unique per forum (forum could not have two categories with the same slug)
         */
        if($forum->categories->where('slug', $slug)->count()) {
            $this->deny(__("Forums could not have two categories with the same slug within the same forum"));
        }

        $fstatus = $forum->status->slug;
        if($fstatus == 'closed') {
            $this->deny(__("You can't add categories on a closed forum"));
        }
        if($fstatus == 'temp.closed') {
            $this->deny(__("You can't add categories on a temporarily closed forum"));
        }

        return true;
    }

    public function update(User $user, $category, $new_slug, $c) {
        // If the admin change the category slug, it must be unique per forum
        if($category->forum->categories->where('id', '<>', $category->id)->where('slug', $new_slug)->count()) {
            $this->deny(__("Forum could not have two categories with the same slug"));
        }
        // If the admin change the category title, it must be unique per forum
        if($category->forum->categories->where('id', '<>', $category->id)->where('category', $c)->count()) {
            $this->deny(__("Forum could not have two categories with the same title"));
        }
        return true;
    }
}
