<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AccountStatus extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'account_status';
}
