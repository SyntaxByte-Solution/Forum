<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\
    {RolesController, PermissionsController, ForumController,
    CategoryController, ThreadController, PostController,
    IndexController, UserController, OAuthController,
    SearchController, FeedbackController, VoteController};
use App\Models\{Thread, Vote};
use App\Http\Middleware\AccountActivationCheck;

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

Route::get('/test', function() {
    $name = "mouad";
    dd("{$name}s");
});

Route::get('/', [IndexController::class, 'index']);
Route::get('/home', [IndexController::class, 'index']);
Route::get('/forums', [IndexController::class, 'forums']);


/**
 * Search routes
 */
Route::get('/{forum:slug}/search', [SearchController::class, 'forum_search'])->name('forum.thread.search');

/**
 * get all forum threads
 * forum.misc -> forum.all.threads
 */
Route::get('/{forum:slug}/all', [ThreadController::class, 'forum_all_threads'])->name('forum.all.threads');

Route::middleware(['auth'])->group(function () {
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

    Route::get('/{forum:slug}/{category:slug}/threads/add', [ThreadController::class, 'create'])->name('thread.add');
    
    Route::get('/{user:username}/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('thread.edit');
    
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

    Route::get('/settings', [UserController::class, 'edit'])->name('user.settings');
    Route::get('/settings/personal', [UserController::class, 'edit_personal_infos'])->name('user.personal.settings');
    Route::get('/settings/passwords', [UserController::class, 'edit_password'])->name('user.passwords.settings');
    Route::get('/settings/account', [UserController::class, 'account_settings'])->name('user.account');

    Route::patch('/settings/profile', [UserController::class, 'update'])->name('change.user.settings.profile');
    Route::patch('/settings/personal', [UserController::class, 'update_personal'])->name('change.user.settings.personal');
    Route::patch('/settings/password/update', [UserController::class, 'update_password'])->name('change.user.settings.password');
    Route::patch('/settings/account/delete', [UserController::class, 'delete_account'])->name('delete.user.account');
    Route::patch('/settings/account/deactivate', [UserController::class, 'deactivate_account'])->name('deactivate.user.account');
    
    Route::get('/settings/account/activate', [UserController::class, 'activate_account'])->name('user.account.activate')->withoutMiddleware([AccountActivationCheck::class]);
    Route::patch('/settings/account/activating', [UserController::class, 'activating_account'])->name('user.account.activating')->withoutMiddleware([AccountActivationCheck::class]);

    Route::post('/thread/{thread}/vote', [VoteController::class, 'thread_vote'])->name('thread.vote');
    Route::post('/post/{post}/vote', [VoteController::class, 'post_vote'])->name('post.vote');
});


Route::get('/{forum:slug}/{category:slug}/threads', [ThreadController::class, 'category_threads'])->name('category.threads');

Route::get('/login/{provider}', [OAuthController::class, 'redirectToProvider']);
Route::get('/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

Route::get('/users/{user:username}/activities', [UserController::class, 'activities'])->name('user.activities');

Route::get('/users/{user:username}/threads', [UserController::class, 'user_threads'])->name('user.threads');
Route::get('/users/{user:username}', [UserController::class, 'profile'])->name('user.profile');
Route::post('/users/username/check', [UserController::class, 'username_check']);

Route::get('/{forum:slug}/{category:slug}/{thread}', [ThreadController::class, 'show'])->name('thread.show');

Route::post('/feedback', [FeedbackController::class, 'store'])->middleware(['throttle:feedback'])->name('feedback.save');
//Route::post('/emojifeedback', [FeedbackController::class, 'store_emojifeedback'])->middleware(['throttle:opd'])->name('feedback.emoji.save');
Route::post('/emojifeedback', [FeedbackController::class, 'store_emojifeedback'])->name('feedback.emoji.save');