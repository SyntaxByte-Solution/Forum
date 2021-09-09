<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ForumStatus, Category, Thread};

class Forum extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getStatusAttribute($value) {
        return ForumStatus::find($value);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function threads() {
        return $this->hasManyThrough(Thread::class, Category::class);
    }

    // public function threads() {
    //     $threads = collect([]);
    //     foreach($this->categories as $category) {
    //         $threads = $threads->merge($category->threads);
    //     }

    //     return $threads;
    // }
}
