<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, User};

class CategoryController extends Controller
{
    public function create() {
        $found = false;

        foreach(User::find(request()->created_by)->first()->roles as $role) {
            if($role->role == 'Moderator') {
                $found = true;
                break;
            }
        }

        if($found) {
            Category::create([
                'category'=>request()->category,
                'created_by'=>request()->created_by
            ]);
        } else {
            throw new \Exception('This user has no permision to create a category');
        }
    }
}
