<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDisable extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'notifications_disables';
    public $timestamps = false;
    
    public function disabled()
    {
        return $this->morphTo();
    }

}
