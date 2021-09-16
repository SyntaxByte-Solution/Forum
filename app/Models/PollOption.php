<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Poll,User};

class PollOption extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'polloptions';

    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
