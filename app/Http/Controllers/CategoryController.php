<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Exceptions\UnauthorizedActionException;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store() {
        if (! Gate::allows('add.category')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }

        $data = request()->validate([
            'category'=>'min:2|max:180|unique:categories,category',
            'slug'=>'min:2|max:180|unique:categories,slug',
            'description'=>'max:2000|nullable',
            'status'=>'exists:category_status,id',
        ]);

        Category::create($data);
    }

    public function update(Category $category) {
        if (! Gate::allows('update.category')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }

        $data = request()->validate([
            'category'=>'sometimes|min:2|max:180|unique:categories,category',
            'slug'=>'sometimes|min:2|max:180|unique:categories,slug',
            'description'=>'sometimes|max:2000|nullable',
            'status'=>'sometimes|exists:category_status,id',
        ]);

        $category->update($data);
    }

    public function destroy(Category $category) {
        if (! Gate::allows('delete.category')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }

        $category->delete();
    }
}
