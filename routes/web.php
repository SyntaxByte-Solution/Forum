<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\
    {RolesController, PermissionsController, 
     CategoryController, ThreadController, PostController,
     SubcategoryController};

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
    return view('index');
    // Here I use verified middleware just for testing
})->middleware(['verified']);

Route::get('/home', function () {
    return view('index');
})->middleware(['verified']);



Route::post('/roles', [RolesController::class, 'create']);
Route::patch('/roles/{role}', [RolesController::class, 'update']);
Route::delete('/roles/{role}', [RolesController::class, 'destroy']);
Route::post('/roles/attach', [RolesController::class, 'attach']);
Route::delete('/users/{user}/roles/{role}/detach', [RolesController::class, 'detach']);

Route::patch('/permissions/{permission}', [PermissionsController::class, 'update']);
Route::delete('/permissions/{permission}', [PermissionsController::class, 'destroy']);

Route::post('roles/{role}/permissions/attach', [PermissionsController::class, 'attach_permission_to_role']);
Route::post('roles/{role}/permissions/{permission}/detach', [PermissionsController::class, 'detach_permission_from_role']);

Route::post('/categories', [CategoryController::class, 'store']);
Route::patch('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

Route::middleware(['auth'])->group(function () {

    Route::post('/thread', [ThreadController::class, 'store']);
    Route::patch('/thread/{thread}', [ThreadController::class, 'update']);
    Route::delete('/thread/{thread}', [ThreadController::class, 'destroy']);

    Route::post('/post', [PostController::class, 'store']);
    Route::patch('/post/{post}', [PostController::class, 'update']);
    Route::delete('/post/{post}', [PostController::class, 'destroy']);

});

/** 
 * The routes that are accessible for only admins should be placed in a group
 * with authorization defined as middleware.
 */

Route::post('/subcategory', [SubcategoryController::class, 'store']);
Route::patch('/subcategory/{subcategory}', [SubcategoryController::class, 'update']);
Route::delete('/subcategory/{subcategory}', [SubcategoryController::class, 'destroy']);
