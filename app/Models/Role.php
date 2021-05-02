<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Permission};

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function has_permission($permission) {
        $permission = ($permission instanceof Permission) ? $permission->permission : $permission;
        foreach($this->permissions as $p) {
            if($p->permission == $permission) {
                return true;
            }
        }

        return false;
    }
}
