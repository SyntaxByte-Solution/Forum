<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = "faqs";
    protected $guarded = [];

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }
}
