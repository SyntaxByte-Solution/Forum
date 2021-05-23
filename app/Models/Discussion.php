<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thread;

class Discussion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function threads() {
        return $this->hasMany(Thread::class);
    }
}
