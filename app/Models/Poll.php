<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{PollOption, OptionVote};

class Poll extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function options() {
        return $this->hasMany(PollOption::class);
    }

    public function votes() {
        return $this->hasManyThrough(
            OptionVote::class, 
            PollOption::class,
            'poll_id',
            'option_id',
            'id',
            'id'
        );
    }

    /**
     *  This will check If the current user already voted an option associated with this poll
     *  voted attribute in PollOption modelc check if the current user vote a particular option
     */
    public function getVotedAttribute() {
        $poll_options_ids = $this->options->pluck('id')->implode(',');
        if(($currentuser = auth()->user()))
            return (bool)\DB::select(
                "SELECT count(*) as found 
                FROM optionsvotes 
                WHERE user_id=$currentuser->id 
                AND option_id In ($poll_options_ids)"
            )[0]->found;
            
        return false;
    }
}
