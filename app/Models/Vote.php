<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the parent votable model (thread or post or ...)
     */
    public function votable() {
        return $this->morphTo();
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }
}
