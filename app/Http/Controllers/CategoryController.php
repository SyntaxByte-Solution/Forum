<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Forum};
use App\Exceptions\DuplicateCategoryException;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'role:admin']);
    }
    
    public function store() {
        $data = request()->validate([
            'category'=>'required|min:2|max:800',
            'slug'=>'required|min:2|max:800',
            'description'=>'required|min:2|max:4000',
            'forum_id'=>'required|exists:forums,id',
            'status'=>'required|exists:category_status,id',
        ]);

        /**
         * category is unique per forum (forum could not have two categories with the same title)
         * First get forum, then fetch its categories, then search if the submitted one exists there
         * If so throw an exception, otherwise move on
         */
        if(Forum::find($data['forum_id'])
            ->categories->where('category', $data['category'])
            ->count())
        {
            throw new DuplicateCategoryException("You can't create two categories with the same title in the same forum");
        }

        Category::create($data);
    }

    public function update(Category $category) {
        $data = request()->validate([
            'category'=>'sometimes|min:2|max:800',
            'description'=>'sometimes|min:2|max:4000',
            'forum_id'=>'sometimes|exists:forums,id',
            'status_id'=>'sometimes|exists:category_status,id',
        ]);

        /**
         * Here we check for the submited category in every category in the forum
         * but we exclude the current category because the admin could keep the same
         * category title
         */
        if(Forum::find($category->forum_id)
            ->categories
            ->whereNotIn('id', $category->id)
            ->where('category', $data['category'])
            ->count())
        {
            throw new DuplicateCategoryException("You're trying to edit the category with an already exist category in this forum");
        }

        $category->update($data);
    }

    public function destroy(Category $category) {
        $category->delete();
    }
}
