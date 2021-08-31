<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'feedbacks';

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }
}
