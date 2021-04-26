<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subdirectories() {
        return $this->hasMany(SubDirectory::class);
    }
}
