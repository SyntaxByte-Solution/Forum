<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        $this->check_moderator();

        $data = request()->validate([
            'subcategory'=>'required|min:2|max:400|unique:subcategories',
            'created_by'=>'required',
            'category_id'=>'required',
        ]);

        SubCategory::create($data);
    }

    public function update(SubCategory $subcategory) {
        $this->check_moderator();

        $data = request()->validate([
            'subcategory'=>'required|min:2|max:400|unique:subcategories',
            'created_by'=>'required',
            'category_id'=>'required',
        ]);

        $subcategory->update($data);
    }

    public function destroy(SubCategory $subcategory) {
        $this->check_moderator();

        $subcategory->delete();
    }

    private function check_moderator() {
        $user = Auth::user();

        foreach($user->roles as $role) {
            if(strtolower($role->role) == 'moderator') {
                return true;
            }
        }

        throw new \Exception('This is user has no permission to do this action');
    }
}
