<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Subcategory, Category};
use App\Exceptions\DuplicateSubcategoryException;

class SubcategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'role:admin']);
    }
    
    public function store() {
        $data = request()->validate([
            'subcategory'=>'required|min:2|max:800',
            'description'=>'required|min:2|max:4000',
            'category_id'=>'required|exists:categories,id'
        ]);

        /**
         * Subcategory is unique per category (category could not have two subdirectories with the same title)
         * First get category, then fetch its subcategories, then search if the submitted one exists there
         * If so throw an exception, otherwise move on
         */
        if(Category::find($data['category_id'])
            ->subcategories->where('subcategory', $data['subcategory'])
            ->count()) 
        {
            throw new DuplicateSubcategoryException("You can't create two subdirectories with the same title in the same category");
        }

        Subcategory::create($data);
    }

    public function update(Subcategory $subcategory) {
        $data = request()->validate([
            'subcategory'=>'sometimes|min:2|max:800',
            'description'=>'sometimes|min:2|max:4000',
            'category_id'=>'sometimes|exists:categories,id'
        ]);

        /**
         * Here we check for the submited subdirectory in every subdirectory in the category
         * but we exclude the current subdirectory because the admin could keep the same
         * subdirectory
         */
        if(Category::find($subcategory->category_id)
            ->subcategories
            ->whereNotIn('id', $subcategory->id)
            ->where('subcategory', $data['subcategory'])
            ->count()) 
        {
            throw new DuplicateSubcategoryException("You're trying to edit the subcategory with an already exist subcategory in this category");
        }

        $subcategory->update($data);
    }

    public function destroy(Subcategory $subcategory) {
        $subcategory->delete();
    }
}
