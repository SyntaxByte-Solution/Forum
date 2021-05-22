<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ForumStatus, Category};

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
}
