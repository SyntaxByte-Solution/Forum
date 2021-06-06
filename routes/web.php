<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\
    {RolesController, PermissionsController, ForumController,
     CategoryController, ThreadController, PostController,
     IndexController, MySpaceController};
use App\Models\Forum;

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

Route::get('/', [IndexController::class, 'index']);
Route::get('/home', [IndexController::class, 'index']);

/** 
 * The routes that are accessible for only admins should be placed in a group
 * with authorization defined as middleware.
 */

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

/**
 * 1. get all discussions & questions of all categories in the specified forum in the url
 * 2. get all discussions of all categories in the specified forum in the url
 * 1. get all questions of all categories in the specified forum in the url
 */
Route::get('/{forum:slug}/all', [ThreadController::class, 'forum_all_threads'])->name('forum.misc');
Route::get('/{forum:slug}/discussions', [ThreadController::class, 'all_discussions'])->name('get.all.forum.discussions');
Route::get('/{forum:slug}/questions', [ThreadController::class, 'all_questions'])->name('get.all.forum.questions');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/myspace', [MySpaceController::class, 'index'])->name('myspace.index');

    Route::get('/{forum:slug}/discussions/add', [ThreadController::class, 'create'])->name('discussion.add');
    Route::get('/{forum:slug}/questions/add', [ThreadController::class, 'create'])->name('question.add');

    Route::get('/{user:username}/discussions/{thread}/edit', [ThreadController::class, 'edit'])->name('discussion.edit');
    Route::get('/{user:username}/questions/{thread}/edit', [ThreadController::class, 'edit'])->name('question.edit');

    Route::post('/forums', [ForumController::class, 'store']);
    Route::patch('/forums/{forum}', [ForumController::class, 'update']);
    Route::delete('/forums/{forum}', [ForumController::class, 'destroy']);

    Route::post('/thread', [ThreadController::class, 'store']);
    Route::patch('/thread/{thread}', [ThreadController::class, 'update']);
    Route::delete('/thread/{thread}', [ThreadController::class, 'delete'])->name('thread.delete');
    Route::delete('/thread/{thread}/force', [ThreadController::class, 'destroy'])->name('thread.destroy');

    Route::post('/post', [PostController::class, 'store']);
    Route::patch('/post/{post}', [PostController::class, 'update']);
    Route::delete('/post/{post}', [PostController::class, 'destroy']);

});

Route::get('/{forum:slug}/{category:slug}/discussions/{thread}', [ThreadController::class, 'show'])->name('discussion.show');
Route::get('/{forum:slug}/{category:slug}/questions/{thread}', [ThreadController::class, 'show'])->name('question.show');

/**
 * 1. get all discussions & questions of the specified category of the forum in the url 
 * (all in the first route means all thread types [Discussions, questions, advices ..])
 * 2. get all discussions of the specified category of the forum in the url
 * 1. get all questions of the specified category of the forum in the url
 */
Route::get('/{forum:slug}/{category:slug}/all', [ThreadController::class, 'category_misc'])->name('category.misc');
Route::get('/{forum:slug}/{category:slug}/discussions', [ThreadController::class, 'category_discussions'])->name('category.discussions');
Route::get('/{forum:slug}/{category:slug}/questions', [ThreadController::class, 'category_questions'])->name('category.questions');
