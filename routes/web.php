<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CategoryController, SubCategoryController, RoleController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/categories', [CategoryController::class, 'create']);
Route::patch('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

Route::post('/subcategories', [SubCategoryController::class, 'create']);
Route::patch('/subcategories/{subcategory}', [SubCategoryController::class, 'update']);
Route::delete('/subcategories/{subcategory}', [SubCategoryController::class, 'destroy']);

Route::post('/roles', [RoleController::class, 'create']);

Route::delete('/users/{user}/roles/{role}', [RoleController::class, 'destroy']);
