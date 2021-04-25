<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Category, User};

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Notice: 
     * The user needs to be authenticated, as well as a moderator if he needs to perform the following tasks
     */

    public function create() {
        $user = Auth::user();
        if(!$this->is_moderator($user)) {
            throw new \Exception('This user has no permission to perform this action');
        }

        $data = request()->validate([
            'category'=>'required|min:2|max:400|unique:categories',
        ]);
        $data['created_by'] = $user->id;

        Category::create($data);
    }

    public function update(Category $category) {
        $user = Auth::user();
        if(!$this->is_moderator($user)) {
            throw new \Exception('This user has no permission to perform this action');
        }

        $data = request()->validate([
            'category'=>'required|min:2|max:400|unique:categories',
        ]);

        $category->update($data);
    }

    public function destroy(Category $category) {
        $user = Auth::user();
        if(!$this->is_moderator($user)) {
            throw new \Exception('This user has no permission to perform this action');
        }

        $category->delete();
    }

    private function is_moderator($user) {
        foreach($user->roles as $role) {
            if(strtolower($role->role) == 'moderator') {
                return true;
            }
        }

        return false;
    }
}
