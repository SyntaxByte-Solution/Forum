<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class CategoryStatus extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "category_status";

}