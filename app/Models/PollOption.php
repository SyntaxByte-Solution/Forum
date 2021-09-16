<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Poll,User,OptionVote};

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

    public function votes() {
        return $this->hasMany(OptionVote::class, 'option_id');
    }

    public function getVotedAttribute() {
        if(($currentuser = auth()->user()))
            return $this->votes()->where('user_id', $currentuser->id)->count() > 0;

        return false;
    }
}
