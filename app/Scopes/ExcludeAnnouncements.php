<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Models\Category;

class ExcludeAnnouncements implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $announcements_categories_ids = Category::withoutGlobalScope(ExcludeAnnouncementFromCategories::class)->where('slug', 'announcements')->pluck('id');
        $builder->whereNotIn('category_id', $announcements_categories_ids);
    }
}