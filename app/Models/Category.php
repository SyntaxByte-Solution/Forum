<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return route('category.threads', ['category'=>$this->id]);
    }
}
