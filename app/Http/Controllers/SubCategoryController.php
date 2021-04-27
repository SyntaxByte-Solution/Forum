<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','moderator']);
    }

    public function create() {
        $data = request()->validate([
            'subcategory'=>'required|min:2|max:400|unique:subcategories',
            'created_by'=>'required',
            'category_id'=>'required',
        ]);

        SubCategory::create($data);
    }

    public function update(SubCategory $subcategory) {
        $data = request()->validate([
            'subcategory'=>'required|min:2|max:400|unique:subcategories',
            'created_by'=>'required',
            'category_id'=>'required',
        ]);

        $subcategory->update($data);
    }

    public function destroy(SubCategory $subcategory) {
        $subcategory->delete();
    }
}
