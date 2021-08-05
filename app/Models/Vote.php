<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExcludeDeactivatedUserData;
use App\Models\User;

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

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected static function booted() {
        static::addGlobalScope(new ExcludeDeactivatedUserData);
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }
}
