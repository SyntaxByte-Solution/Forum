<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\
    {RolesController, PermissionsController, 
     CategoryController, ThreadController};

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
});
