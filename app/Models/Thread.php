<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{User, Post, Category, Forum, Vote};

class Thread extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function votes() {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function scopeToday($builder)
    {
        return $builder->where('created_at', '>', today());
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function forum() {
        return Forum::find($this->category->forum_id);
    }
}
