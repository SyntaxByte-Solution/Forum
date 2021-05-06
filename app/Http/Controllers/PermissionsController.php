<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Permission, Role};

class PermissionsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    
}
