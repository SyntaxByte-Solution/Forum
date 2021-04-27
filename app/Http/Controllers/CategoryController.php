<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Category, User};

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','moderator']);
    }

    /**
     * Notice: 
     * The user needs to be authenticated, as well as a moderator if he needs to perform the following tasks
     * Later try to define a moderator middleware and assign it to the controllers's constructor
     */

    public function create() {
        $data = request()->validate([
            'category'=>'required|min:2|max:400|unique:categories',
        ]);
        $data['created_by'] = request()->user()->id;

        Category::create($data);
    }

    public function update(Category $category) {
        $data = request()->validate([
            'category'=>'required|min:2|max:400|unique:categories',
        ]);
        $category->update($data);
    }

    public function destroy(Category $category) {
        $category->delete();
    }
}
