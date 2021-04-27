<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Classes\TestHelper;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'moderator']);
    }

    public function create() {
        $data = request()->validate([
            'role'=>'required|min:2|max:100'
        ]);

        Role::create($data);
    }
}
