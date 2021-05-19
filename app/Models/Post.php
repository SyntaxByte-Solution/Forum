<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thread;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function thread() {
        return $this->belongsTo(Thread::class);
    }
}
