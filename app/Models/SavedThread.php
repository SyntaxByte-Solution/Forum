<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedThread extends Model
{
    use HasFactory;

    protected $table = 'saved_threads';
    protected $guarded = [];
    public $timestamps = false;
    
}
