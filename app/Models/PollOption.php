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
    public $with = ['user'];

    public static function boot() {
        parent::boot();

        static::deleting(function($option) {
            $option->votes()->delete();
        });
    }

    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function votes() {
        return $this->hasMany(OptionVote::class, 'option_id');
    }

    public function getVotedandvotescountAttribute() {
        $voted = false;
        $count = 0;
        
        $result = \DB::select('SELECT user_id FROM optionsvotes WHERE option_id=?', [$this->id]);
        $result =  array_column($result, 'user_id');
        if(!auth()->user()) {
            $voted = false;
            $count = count($result);
        } else {
            $count = count($result);
            if($count) // We don't have to check whether a user like a thread if it has no likes
                $voted = in_array(auth()->user()->id, $result);
        }

        return [
            'voted'=>$voted,
            'count'=>$count
        ];
    }

    public function getVotedAttribute() {
        if(($currentuser = auth()->user()))
            return $this->votes()->where('user_id', $currentuser->id)->count() > 0;

        return false;
    }
}
