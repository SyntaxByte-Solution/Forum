<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExcludeAnnouncementFromCategories;
use App\Models\{Forum, Thread};

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];

    public function forum() {
        return $this->belongsTo(Forum::class);
    }

    public function threads() {
        return $this->hasMany(Thread::class);
    }

    public function getLinkAttribute() {
        return route('category.threads', ['forum'=>$this->forum->slug, 'category'=>$this->slug]);
    }

    /**
     * Here we have to exclude announcements from categories using local scopes due to interconnected links between threads
     * and categories. using local scopes require us to add the scope everytime we want to exclude announcements
     */
    public function scopeExcludeannouncements($query) {
        return $query->where('slug', '<>', 'announcements');
    }
}
