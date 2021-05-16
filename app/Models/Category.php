<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{SCategory, CStatus};

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getStatusAttribute($value) {
        return CStatus::find($value);
    }
}
