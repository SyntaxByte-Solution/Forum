<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Category, User};

class CategoryController extends Controller
{
    public function create() {
        $user = User::find(request()->created_by)->first();
    
        if($this->is_moderator($user)) {
            Category::create([
                'category'=>request()->category,
                'created_by'=>request()->created_by
            ]);
        } else {
            throw new \Exception('This user has no permision to create a category');
        }
    }

    public function update(Category $category) {
        
        // In case of update we need first to grab the authenticated user to see if it is a moderator
        $user = Auth::user();

        if(!$this->is_moderator($user)) {
            throw new \Exception('This user has no permision to create a category');
        }
    
        $data = request()->validate([
            'category'=>'required',
            'created_by'=>'required'
        ]);

        $c = Category::find($category->id)->update($data);
    }

    public function destroy(Category $category) {
        $user = Auth::user();

        if(!$this->is_moderator($user)) {
            throw new \Exception('This user has no permissions to do this action');
        } else {
            $category->delete();        
        }
    }

    private function is_moderator($user) {
        foreach($user->roles as $role) {
            if($role->role == 'Moderator') {
                return true;
            }
        }

        return false;
    }
}
