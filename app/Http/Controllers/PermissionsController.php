<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\{Permission, Role};
use App\Exceptions\UnauthorizedActionException;

class PermissionsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function update(Permission $permission) {
        if (! Gate::allows('update.permissions')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing in roles and permissions.");
        }

        $data = request()->validate([
            'permission'=>'required|max:400'
        ]);

        $permission->update($data);
    }
}
