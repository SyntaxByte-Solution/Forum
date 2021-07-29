<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\
    {RolesController, PermissionsController, ForumController,
    CategoryController, ThreadController, PostController,
    IndexController, UserController, OAuthController,
    SearchController, FeedbackController, VoteController,
    LikesController, GeneralController, MultilanguageHelperController,
    NotificationController, FollowController, ReportController};
use App\Models\{User, Thread, Post};
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
    $user = auth()->user();
    $thread = Thread::first();

    dd($thread->visibility->icon);
});

Route::get('/', [IndexController::class, 'index']);
Route::get('/home', [IndexController::class, 'index']);
Route::get('/forums', [IndexController::class, 'forums']);

Route::post('/setlang', [GeneralController::class, 'setlang']);

/**
 * Multilanguage helper routes
 */
Route::get('/languages/helper', [MultilanguageHelperController::class, 'index']);
Route::get('/languages/{lang}/keys', [MultilanguageHelperController::class, 'get_keys']);
/**
 * Search routes
 */
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search/advanced', [SearchController::class, 'search_advanced'])->name('advanced.search');
Route::get('/search/advanced/results', [SearchController::class, 'search_advanced_results'])->name('advanced.search.results');
Route::get('/threads/search', [SearchController::class, 'threads_search'])->name('threads.search');
Route::get('/users/search', [SearchController::class, 'users_search'])->name('users.search');

/**
 * get all forum threads
 */
Route::get('/{forum:slug}/all', [ThreadController::class, 'forum_all_threads'])->name('forum.all.threads');

Route::get('/forums/{forum}/categories/ids', [GeneralController::class, 'get_forum_categories_ids']);
Route::get('/threads/{thread}/viewer_infos_component', [ThreadController::class, 'view_infos_component']);
Route::get('/thread/{thread}/viewer/posts/load', [ThreadController::class, 'viewer_replies_load']);

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

    Route::get('/notifications', [NotificationController::class, 'notifications'])->name('user.notifications');
    Route::post('/notifications/markasread', [NotificationController::class, 'mark_as_read']);
    Route::post('/notification/generate', [NotificationController::class, 'notification_generate']);
    Route::get('/notifications/generate', [NotificationController::class, 'notification_generate_range']);
    Route::post('/notification/{notification_id}/disable', [NotificationController::class, 'disable']);
    Route::post('/notification/{notification_id}/enable', [NotificationController::class, 'enable']);
    Route::delete('/notification/{notification_id}/delete', [NotificationController::class, 'destroy']);

    Route::post('/users/{user}/follow', [FollowController::class, 'follow_user']);
    Route::post('/threads/{thread}/follow', [FollowController::class, 'follow_thread']);
    Route::get('/users/{user}/followers/load', [FollowController::class, 'followers_load']);
    Route::get('/users/{user}/follows/load', [FollowController::class, 'follows_load']);

    Route::get('/threads/add', [ThreadController::class, 'create'])->name('thread.add');
    Route::get('/{user:username}/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('thread.edit');

    Route::post('/forums', [ForumController::class, 'store']);
    Route::patch('/forums/{forum}', [ForumController::class, 'update']);
    Route::delete('/forums/{forum}', [ForumController::class, 'destroy']);
    
    Route::post('/thread', [ThreadController::class, 'store']);
    Route::patch('/thread/visibility/patch', [ThreadController::class, 'update_visibility']);
    Route::patch('/thread/{thread}', [ThreadController::class, 'update']);
    Route::delete('/thread/{thread}', [ThreadController::class, 'delete'])->name('thread.delete');
    Route::post('/thread/{thread}/report', [ReportController::class, 'thread_report']);
    Route::post('/thread/{thread}/save', [ThreadController::class, 'thread_save_switch']);
    Route::delete('/thread/{thread}/force', [ThreadController::class, 'destroy'])->name('thread.destroy');
    Route::post('/thread/{thread}/posts/switch', [ThreadController::class, 'thread_posts_switch'])->name('thread.posts.turn.off');
    
    Route::post('/post', [PostController::class, 'store']);
    Route::patch('/post/{post}', [PostController::class, 'update']);
    Route::delete('/post/{post}', [PostController::class, 'destroy']);
    Route::get('/post/{post}/content/fetch', [PostController::class, 'post_raw_content_fetch']);
    Route::get('/post/{post}/content/parsed/fetch', [PostController::class, 'post_parsed_content_fetch']);
    Route::get('/post/{post}/show/generate', [PostController::class, 'thread_show_post_generate']);
    Route::get('/post/{post}/viewer/generate', [PostController::class, 'thread_viewer_post_generate']);
    Route::post('/post/{post}/tick', [PostController::class, 'tick']);

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

    Route::post('/thread/{thread}/like', [LikesController::class, 'thread_like']);
    Route::post('/post/{post}/like', [LikesController::class, 'post_like']);

    Route::post('/thread/{thread}/vote', [VoteController::class, 'thread_vote'])->name('thread.vote');
    Route::post('/post/{post}/vote', [VoteController::class, 'post_vote'])->name('post.vote');
});

Route::get('/users/{user:username}/threads', [UserController::class, 'user_threads'])->name('user.threads');
Route::get('/{forum:slug}/{category:slug}/threads', [ThreadController::class, 'category_threads'])->name('category.threads');

Route::get('/login/{provider}', [OAuthController::class, 'redirectToProvider']);
Route::get('/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

Route::get('/users/{user:username}/activities', [UserController::class, 'activities'])->name('user.activities');

Route::get('/users/{user:username}', [UserController::class, 'profile'])->name('user.profile');
Route::post('/users/username/check', [UserController::class, 'username_check']);

Route::get('/{forum:slug}/{category:slug}/{thread}', [ThreadController::class, 'show'])->name('thread.show');

Route::post('/feedback', [FeedbackController::class, 'store'])->middleware(['throttle:feedback'])->name('feedback.save');
//Route::post('/emojifeedback', [FeedbackController::class, 'store_emojifeedback'])->middleware(['throttle:opd'])->name('feedback.emoji.save');
Route::post('/emojifeedback', [FeedbackController::class, 'store_emojifeedback'])->name('feedback.emoji.save');