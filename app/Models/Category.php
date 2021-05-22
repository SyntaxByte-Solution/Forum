<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forum;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];
    
    public function category() {
        return $this->belongsTo(Forum::class);
    }

}
