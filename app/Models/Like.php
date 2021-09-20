<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExcludeDeactivatedUserData;
use App\Models\User;

class Like extends Model
{
    use HasFactory;

    protected $table = "likes";
    protected $guarded = [];

    public function likable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected static function booted() {
        // We don't want to check the like owner if his account is deactivated or not in every like because there's no point to do so and It affect the performance
        // static::addGlobalScope(new ExcludeDeactivatedUserData);
    }
}
