<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'contact_messages';

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }
}
