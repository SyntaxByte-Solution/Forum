<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Filesystem\Filesystem;
use Request as Rqst;
use Carbon\Carbon;
use App\Exceptions\{DuplicateThreadException, CategoryClosedException, AccessDeniedException};
use App\Models\{Forum, Thread, Category, CategoryStatus, User, UserReach, ThreadVisibility, Post, Like};
use App\View\Components\IndexResource;
use App\View\Components\Thread\{ViewerInfos, ViewerReply};
use App\View\Components\Activities\ActivityThread;
use App\View\Components\Activities\Sections\{Threads, SavedThreads, LikedThreads, VotedThreads, ArchivedThreads, ActivityLog};
use App\Http\Controllers\PostController;
use App\Scopes\ExcludeAnnouncements;

class ThreadController extends Controller
{
    public function show(Request $request, Forum $forum, Category $category, Thread $thread) {
        $posts_per_page = 10;
        if(!(Auth::check() && auth()->user()->id == $thread->user->id)) {
            $thread->update([
                'view_count'=>$thread->view_count+1
            ]);
        }

        $tickedPost = $thread->tickedPost();
        if($tickedPost) {
            $posts = $thread->posts()->where('id', '<>', $tickedPost->id)->orderBy('created_at', 'desc')->paginate($posts_per_page);
            if(request()->has('page') && request()->get('page') != 1) {
                $tickedPost = false;
            }
        } else {
            $posts = $thread->posts()->orderBy('created_at', 'desc')->paginate($posts_per_page);
        }

        // redirect the user to the appropriate page is thread has too many posts
        if(request()->has('reply')) {
            $reply_id = request()->get('reply');
            $count = 1;
            foreach($posts as $post) {
                if($post->id == $reply_id) {
                    break;
                }
                $count++;
            }
            $page = ceil($count / $posts_per_page);

            return redirect($thread->link . "?page=".$page);
        }

        $current_user = auth()->user();
        if($current_user) {
            $postsbyusers = $posts->where('user_id', '<>', $current_user->id)->groupBy('user_id');
        } else {
            $postsbyusers = $posts->groupBy('user_id');
        }

        $postperuser = [];
        foreach($postsbyusers as $group) {
            $postperuser[] = $group->first();
        } // Results now will hold posts unique by users

        // The following foreach will loop through each owner of all posts of the page
        foreach($postperuser as $post) {
            // Here we just create userreach record
            $reach = new UserReach;
            // We only set reacher in case the user is authenticated
            if($current_user) {
                $reach->reacher = $current_user->id;
            }
            $reach->reachable = $post->user->id;
            $reach->resource_id = $post->id;
            $reach->resource_type = 'post';
            $reach->reacher_ip = $request->ip();

            /**
             * Before saving the userreach we need to check if the user has already reach the post of the current page before;
             * If so we don't have to increment the reach because the post is already reached by the current user
             * NOTICE: If a user has 2 or more posts in the same page we only increment reach once per watch
             * by taking only one post from user posts in the page and reference it in the reach table
             */
            $found = UserReach::where('reachable', $post->user->id)
                ->where('resource_id', $post->id)
                ->where('resource_type', 'post');
            if($current_user)
                $found = $found->where('reacher', $current_user->id)->count();
            else
                $found = $found->where('reacher_ip', $request->ip())->count();

            if(!$found) {
                /**
                 * Notice that we don't have to check if the current user is exists to not increment the reach
                 * because we exclude all current user posts before looping in the current foreach
                 */
                $reach->save();
            }
        }

        return view('forum.thread.show')
            ->with(compact('forum'))
            ->with(compact('thread'))
            ->with(compact('tickedPost'))
            ->with(compact('posts'));
    }
    public function announcement_show(Request $request, Forum $forum, $announcid) {
        $announcement = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($announcid);
        $forums = Forum::all();
        $at = (new Carbon($announcement->created_at))->toDayDateTimeString();
        $at_hummans = (new Carbon($announcement->created_at))->diffForHumans();
        $pagesize = 6;

        $announcement->update([
            'view_count'=>$announcement->view_count+1
        ]);

        $tickedPost = $announcement->tickedPost();
        
        if($tickedPost) {
            $posts = $announcement->posts()->where('id', '<>', $tickedPost->id)->orderBy('created_at', 'desc')->paginate($pagesize);
            if(request()->has('page') && request()->get('page') != 1) {
                $tickedPost = false;
            }
        } else {
            $posts = $announcement->posts()->orderBy('created_at', 'desc')->paginate($pagesize);
        }

        return view('forum.thread.announcement-show')
        ->with(compact('forum'))
        ->with(compact('forums'))
        ->with(compact('posts'))
        ->with(compact('at'))
        ->with(compact('at_hummans'))
        ->with(compact('tickedPost'))
        ->with(compact('announcement'));
    }
    public function create() {
        $this->authorize('create', Thread::class);

        return view('forum.thread.create');
    }
    public function edit(User $user, Thread $thread) {
        $this->authorize('edit', $thread);

        $category = Category::find($thread->category_id);
        $forum = Forum::find($category->forum_id);
        $categories = $forum->categories()->excludeannouncements()->get();
        $medias = [];
        if($thread->has_media) {
            $medias_urls = Storage::disk('public')->files('users/' . $user->id . '/threads/' . $thread->id . '/medias');
            foreach($medias_urls as $media) {
                $media_type;
                $media_source = $media;
                $mime = mime_content_type($media);
                if(strstr($mime, "video/")){
                    $media_type = 'video';
                }else if(strstr($mime, "image/")){
                    $media_type = 'image';
                }

                $medias[] = ['frame'=>$media_source, 'type'=>$media_type];
            }
        }

        return view('forum.thread.edit')
            ->with(compact('forum'))
            ->with(compact('category'))
            ->with(compact('categories'))
            ->with(compact('medias'))
            ->with(compact('thread'));
    }
    public function store(Request $request) {
        /**
         * Notice that we accept visibility_id as slug change it to its associated visibility id later
         * Also it's optional (sometimes) because it has a default value
         */
        $data = request()->validate([
            'subject'=>'required|min:2|max:1000',
            'content'=>'required|min:2|max:40000',
            'category_id'=>'required|exists:categories,id',
            'visibility_id'=>'sometimes|exists:thread_visibility,slug',
            'content'=>'required|min:2|max:40000',
        ]);
        $this->authorize('store', [Thread::class, $data['category_id']]);

        // If the user add images to thread we have to validate them
        if(request()->has('images')) {
            $validator = Validator::make(
                $request->all(), [
                'images.*' => 'file|mimes:jpg,png,jpeg,gif,bmp|max:12000',
                'images' => 'max:20',
                ],[
                    'images.*.mimes' => __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported'),
                    'images.*.max' => __('Maximum allowed size for an image is 12MB'),
                ]
            );

            if ($validator->fails()) {
                abort(422, $validator->errors());
            }
        }
        if(request()->has('videos')) {
            $validator = Validator::make(
                $request->all(), [
                'videos.*' => 'file|mimes:mp4,webm,mpg,mp2,mpeg,mpe,mpv,ogg,mp4,m4p,m4v,avi|max:500000',
                'videos' => 'max:4',
                ],[
                    'videos.*.mimes' => __('Only .MP4, .WEBM, .MPG, .MP2, .MPEG, .MPE, .MPV, .OGG, .M4P, .M4V, .AVI video formats are supported'),
                    'videos.*.max' => __('Maximum allowed size for a video is 500MB'),
                ]
            );

            if ($validator->fails()) {
                abort(422, $validator->errors());
            }
        }

        // Prevent user from sharing two threads with the same subject in the same category
        $duplicated_thread;
        $duplicated_thread_url;
        if(auth()->user()->threads
            ->where('subject', $data['subject'])
            ->where('category_id', $data['category_id'])->count()) {

            $duplicated_thread = auth()->user()->threads
            ->where('subject', $data['subject'])
            ->where('category_id', $data['category_id'])->first();

            /**
             * If there's a duplicate subjects in the same category we need to 
             * reload the page by passing flash message to inform the user
             */
            $forum = Forum::find(Category::find($data['category_id'])->forum_id)->slug;
            $category = Category::find($data['category_id'])->slug;

            $duplicate_thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicated_thread->id]);
            return response()->json(['error' => __("This title is already exists in your discussions list within the same category which is not allowed") . " (<a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>" . __('see discussion') . "</a>), " . __("please choose another title or edit the title of the old discussion")], 422);
        }

        $data['user_id'] = auth()->user()->id;

        // Verify if status is submitted !
        if($data['visibility_id']) {
            $data['visibility_id'] = ThreadVisibility::where('slug', $data['visibility_id'])->first()->id;
        }
        // Verify if medias are uploaded with thread !
        if(request()->has('images') || request()->has('videos')) {
            $data['has_media'] = 1;   
        }

        // Create the thread
        $thread = Thread::create($data);

        // Create a folder inside thread_owner folder with its id as name
        $path = public_path().'/users/' . $data['user_id'] . '/threads/' . $thread->id;
        File::makeDirectory($path, 0777, true, true);

        // Verify if there's uploaded images
        if(request()->has('images')) {
            foreach($request->images as $image) {
                $image->storeAs(
                    'users/'.$data['user_id'].'/threads/'.$thread->id.'/medias', $image->getClientOriginalName(), 'public'
                );
            }
        }
        // Verify if there's uploaded videos
        if(request()->has('videos')) {
            foreach($request->videos as $video) {
                $video->storeAs(
                    'users/'.$data['user_id'].'/threads/'.$thread->id.'/medias', $video->getClientOriginalName(), 'public'
                );
            }
        }

        // Notify the followers
        foreach(auth()->user()->followers as $follower) {
            $follower = User::find($follower->follower);
            
            $follower->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>auth()->user()->id,
                    'action_statement'=>"Shared a new discussion :",
                    'resource_string_slice'=>$thread->slice,
                    'action_type'=>'thread-action',
                    'action_date'=>now(),
                    'action_resource_id'=>$thread->id,
                    'action_resource_link'=>$thread->link,
                ])
            );
        }

        return [
            'link'=>$thread->link,
            'id'=>$thread->id
        ];
    }
    public function update(Request $request, Thread $thread) {
        $this->authorize('update', $thread);

        $forum = Forum::find(Category::find($thread->category_id)->forum_id)->slug;
        $category = Category::find($thread->category_id)->slug;

        $data = request()->validate([
            'subject'=>'sometimes|min:2|max:1000',
            'content'=>'sometimes|min:2|max:40000',
            'replies_off'=>'sometimes|boolean',
            'category_id'=>'sometimes|exists:categories,id',
            'status_id'=>'sometimes|exists:thread_status,id',
        ]);

        if($category == 'announcements') {
            return abort(403, __("You could not create announcements due to privileges unavailability"));
        }

        // Prevent sharing a thread with the same subject in the same category
        if(auth()->user()->threads
            ->where('subject', $data['subject'])
            ->where('category_id', $data['category_id'])
            ->where('id', '<>', $thread->id)->count()) {

            $duplicated_thread = auth()->user()->threads
                ->where('subject', $data['subject'])
                ->where('category_id', $data['category_id'])
                ->where('id', '<>', $thread->id)->first();

            // If same subject within same category found, we simply abort the request with the appropriate erro and return it
            $duplicate_thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$duplicated_thread->id]);
            return response()->json(['error' => __("This title is already exists in your discussions list within the same category which is not allowed") . " ( <a class='link-path' target='_blank' href='" . $duplicate_thread_url . "'>" . __('see discussion') . "</a> ), " . __("please choose another title or edit the title of the old discussion")], 422);
        }

        // If the user add images to thread we have to validate them
        if(request()->has('images')) {
            $validator = Validator::make(
                $request->all(), [
                'images.*' => 'file|mimes:jpg,png,jpeg,gif,bmp|max:12000',
                'images' => 'max:20',
                ],[
                    'images.*.mimes' => __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported'),
                    'images.*.max' => __('Maximum allowed size for an image is 12MB'),
                ]
            );

            if ($validator->fails()) {
                abort(422, $validator->errors());
            } else {
                foreach($request->images as $image) {
                    $image->storeAs(
                        'users/' . $thread->user->id . '/threads/' . $thread->id . '/medias', $image->getClientOriginalName(), 'public'
                    );
                }

                $data['has_media'] = 1;
            }
        }
        if(request()->has('videos')) {
            $validator = Validator::make(
                $request->all(), [
                'videos.*' => 'file|mimes:mp4,webm,mpg,mp2,mpeg,mpe,mpv,ogg,mp4,m4p,m4v,avi|max:500000',
                'videos' => 'max:4',
                ],[
                    'videos.*.mimes' => __('Only .MP4, .WEBM, .MPG, .MP2, .MPEG, .MPE, .MPV, .OGG, .M4P, .M4V, .AVI video formats are supported'),
                    'videos.*.max' => __('Maximum allowed size for a video is 500MB'),
                ]
            );

            if ($validator->fails()) {
                abort(422, $validator->errors());
            } else {
                foreach($request->videos as $video) {
                    $video->storeAs(
                        'users/' . $thread->user->id . '/threads/' . $thread->id . '/medias', $video->getClientOriginalName(), 'public'
                    );
                }

                $data['has_media'] = 1;
            }
        }

        if($request->has('removed_medias')) {
            // Here we don't have to delete files directly, because we have to check if the deleted files blong to the thread
            $removed_medias_urls = json_decode($request->removed_medias);

            foreach($removed_medias_urls as $media_url) {
                $file_name = basename($media_url);
                $file_path = 'users/' . $thread->user->id . '/threads/' . $thread->id . '/medias/' . $file_name;
                $exists = Storage::disk('public')->exists($file_path);
                
                if($exists) {
                    Storage::disk('public')->move(
                        $file_path, 
                        'users/' . $thread->user->id . '/threads/' . $thread->id . '/trash/' . $file_name
                    );
                }
            }

            $FileSystem = new Filesystem();
            // Target directory.
            $directory = public_path('users/' . $thread->user->id . '/threads/' . $thread->id . '/medias');

            // Check if the directory exists.
            if ($FileSystem->exists($directory)) {
                // Get all files in this directory.
                $files = $FileSystem->files($directory);

                // Check if media directory is empty.
                if(empty($files)) {
                    $data['has_media'] = 0;  
                }
            }
        }

        $thread->update($data);

        return $thread->link;
    }

    public function update_visibility(Request $request) {
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id',
            'visibility_slug'=>'required|exists:thread_visibility,slug'
        ]);
        
        $thread = Thread::find($data['thread_id']);
        $this->authorize('update', $thread);

        $thread->update([
            'visibility_id'=>ThreadVisibility::where('slug', $data['visibility_slug'])->first()->id
        ]);
    }
    public function delete(Thread $thread) {
        $this->authorize('delete', $thread);
        
        /**
         * Notice here we don't have to delete the related resource because we used soft
         * deleting so the user could restore the thread later. But we need to clean things up when the
         * user choose permanent delete !
         */

        $thread->delete();
        return route('user.activities', ['user'=>auth()->user()->username, 'section'=>'archived-threads']);
    }
    public function destroy($thread) {
        /**
         * The reason why we didn't use route model binding is because the model is already soft deleted
         * and we're gonna get an error while fetching the model. se we get only the id 
         */
        $thread = Thread::withTrashed()->where('id', $thread)->get()->first();
        $this->authorize('destroy', $thread);

        // You may be wondering about deleting the related resources: look at the boot method in Thread model
        $thread->forceDelete();
        return route('user.activities', ['user'=>auth()->user()->username]);
    }
    public function restore($thread) {
        /**
         * The reason why we didn't use route model binding see the method above docs
         */
        $thread = Thread::withTrashed()->where('id', $thread)->get()->first();
        $this->authorize('update', $thread);

        $thread->restore();

        return $thread->link;
    }
    public function thread_posts_switch(Request $request, Thread $thread) {
        $this->authorize('update', $thread);

        $data = $request->validate([
            'switch'=>[
                'required',
                Rule::in([0, 1]),
            ]
        ]);

        $thread->update([
            'replies_off'=> $data['switch']
        ]);

        $forum = Forum::find(Category::find($thread->category_id)->forum_id)->slug;
        $category = Category::find($thread->category_id)->slug;

        return route('thread.show', ['forum'=>$forum, 'category'=>$category, 'thread'=>$thread->id]);
    }
    public function thread_save_switch(Request $request, Thread $thread) {
        $this->authorize('save', $thread);

        $data = $request->validate([
            'save_switch'=>[
                'required',
                Rule::in(['save', 'unsave']),
            ]
        ]);
        
        $current_user = auth()->user();
        if($data['save_switch'] == 'save') {
            // Check first if it exists; only save it if it's not exist
            if(!$current_user->savedthreads->contains($thread->id)) {
                $current_user->savedthreads()->attach($thread->id);
            }

            return 1;
        }
        $current_user->savedthreads()->detach($thread->id);
        return -1;
    }
    public function forum_all_threads(Request $request, Forum $forum) {
        $pagesize = 8;
        $tab_title = 'All'; // By default is all, until the user choose other option
        $tab = "all";

        $categories = $forum->categories()->excludeannouncements()->get();
        $category = $forum->categories->first();

        // First get all forum's categories
        $categories_ids = $categories->pluck('id');
        $threads = Thread::whereIn('category_id', $categories_ids);
        // Fetching forum announcement id to help us get announcements
        $forum_announcement_id = Category::where('slug', 'announcements')->where('forum_id', $forum->id)->first()->id;
        // Fetch announcements of the visited forum
        $announcements = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->where('category_id', $forum_announcement_id)->orderBy('created_at', 'desc')->take(3)->get();

        // Then we fetch all threads in those categories
        if($request->has('tab')) {
            $tab = $request->input('tab');
            if($tab == 'today') {
                $threads = $threads->today()->orderBy('view_count', 'desc');
                $tab_title = __('Today');
            } else if($tab == 'thisweek') {
                $threads = $threads->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc');
                $tab_title = __('This week');
            }
        }
        $hasmore = $threads->count() > $pagesize ? 1 : 0;
        $threads = $threads->orderBy('created_at', 'desc')->paginate($pagesize);
        
        return view('forum.category.categories-threads')
        ->with(compact('tab'))
        ->with(compact('tab_title'))
        ->with(compact('forum'))
        ->with(compact('categories'))
        ->with(compact('category'))
        ->with(compact('announcements'))
        ->with(compact('threads'))
        ->with(compact('pagesize'))
        ->with(compact('hasmore'));
    }
    public function category_threads(Request $request, Forum $forum, Category $category) {
        $tab = "all";
        $tab_title = 'All';

        $category = $category;
        $categories = $forum->categories()->where('slug', '<>', 'announcements')->get();
        $forums = Forum::all();

        $pagesize = 8;

        $threads = Thread::where('category_id', $category->id);

        if($request->has('tab')) {
            $tab = $request->input('tab');
            if($tab == 'today') {
                $threads = $threads->today()->orderBy('view_count', 'desc');
                $tab_title = __('Today');
            } else if($tab == 'thisweek') {
                $threads = $threads->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc');
                $tab_title = __('This week');
            }
        }
        $hasmore = $threads->count() > $pagesize ? 1 : 0;
        $threads = $threads->orderBy('created_at', 'desc')->paginate($pagesize);

        return view('forum.category.category-threads')
        ->with(compact('tab'))
        ->with(compact('tab_title'))
        ->with(compact('forum'))
        ->with(compact('forums'))
        ->with(compact('category'))
        ->with(compact('categories'))
        ->with(compact('threads'))
        ->with(compact('pagesize'))
        ->with(compact('hasmore'));
    }
    // --------------- Activity sections and components generating ---------------
    // viewer infos component
    public function view_infos_component(Thread $thread) {
        $thread_component = (new ViewerInfos($thread));
        $thread_component = $thread_component->render(get_object_vars($thread_component))->render();

        return $thread_component;
    }
    // range of viewer replies
    public function viewer_replies_load(Request $request, Thread $thread) {
        $data = $request->validate([
            'range'=>'required|Numeric',
            'skip'=>'required|Numeric',
        ]);

        $ticked_post = $thread->tickedPost();
        if($ticked_post) {
            $posts_to_return = $thread->posts()->where('id', '<>', $ticked_post->id)->orderBy('created_at', 'desc')->get()->skip($data['skip'])->take($data['range']);
        } else {
            $posts_to_return = $thread->posts->sortByDesc('created_at')->skip($data['skip'])->take($data['range']);
        }
        $payload = "";

        foreach($posts_to_return as $post) {
            $post_component = (new ViewerReply($post));
            $post_component = $post_component->render(get_object_vars($post_component))->render();
            $payload .= $post_component;
        }

        $hasnext = $thread->posts->skip($data['skip']+$data['range'])->count() > 0;
        return [
            "hasNext"=> $hasnext,
            "content"=>$payload,
            "count"=>$posts_to_return->count()
        ];
    }
    // sections
    public function generate_section(User $user, $section) {
        
        if( is_null($section) ) {
            abort(422, __('Section is required'));
        }
        
        $sections = ['threads', 'liked-threads', 'voted-threads'];
        if(Auth::check() && auth()->user()->id == $user->id) {
            $sections[] = 'saved-threads';
            $sections[] = 'archived-threads';
            $sections[] = 'activity-log';
        }

        if(!in_array($section, $sections)) {
            abort(422, __('Invalide section name'));
        }

        switch($section) {
            case 'threads':
                $threads_section = (new Threads($user));
                return $threads_section->render(get_object_vars($threads_section))->render();
                break;
            case 'saved-threads':
                $saved_threads_section = (new SavedThreads($user));
                return $saved_threads_section->render(get_object_vars($saved_threads_section))->render();
                break;
            case 'liked-threads':
                $liked_threads_section = (new LikedThreads($user));
                return $liked_threads_section->render(get_object_vars($liked_threads_section))->render();
                break;
            case 'voted-threads':
                $voted_threads_section = (new VotedThreads($user));
                return $voted_threads_section->render(get_object_vars($voted_threads_section))->render();
                break;
            case 'archived-threads':
                $archived_threads = (new ArchivedThreads);
                return $archived_threads->render(get_object_vars($archived_threads))->render();
                break;
            case 'activity-log':
                $activity_logs = (new ActivityLog);
                return $activity_logs->render();
                break;
        }
    }
    // range of section's threads
    public function generate_section_range(Request $request, User $user) {
        $sections = ['threads', 'liked-threads', 'voted-threads'];
        if(Auth::check()) {
            if(auth()->user()->id == $user->id) {
                $sections[] = 'saved-threads';
                $sections[] = 'archived-threads';
                $sections[] = 'activity-log';
            }
        }
        $data = $request->validate([
            'section'=>[
                'required',
                Rule::in($sections)
            ],
            'range'=>'required|Numeric',
            'skip'=>'required|Numeric',
        ]);

        switch($data['section']) {
            case 'threads':
                $threads = $user->threads()->without(['votes', 'posts', 'likes'])->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['range'])->get();

                $payload = "";

                foreach($threads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $user->threads()->count() > $data['skip'] + $data['range'],
                    "content"=>$payload,
                    "count"=>$threads->count()
                ];
                break;
            case 'saved-threads':
                $savedthreads = $user->savedthreads()->without(['votes', 'posts', 'likes'])->skip($data['skip'])->take($data['range'])->get();

                $payload = "";

                foreach($savedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $user->savedthreads()->count() > $data['skip'] + $data['range'],
                    "content"=>$payload,
                    "count"=>$savedthreads->count()
                ];
                break;
            case 'liked-threads':
                $totaluserlikedthreads = $user->threadslikes()->count();
                $likedthreads = $user->liked_threads($data['skip'], $data['range']); // Skip skip and take range

                $payload = "";
                foreach($likedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $totaluserlikedthreads > $data['skip'] + $likedthreads->count(),
                    "content"=>$payload,
                    "count"=>$likedthreads->count()
                ];
                break;
            case 'voted-threads':
                $totaluservotedthreads = $user->threadsvotes()->count();
                $votedthreads = $user->voted_threads($data['skip'], $data['range']);

                $payload = "";

                foreach($votedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $totaluservotedthreads > $data['skip'] + $votedthreads->count(),
                    "content"=>$payload,
                    "count"=>$votedthreads->count()
                ];
                break;
            case 'archived-threads':
                $archivedthreads = $user->archivedthreads->without(['posts', 'likes', 'votes'])->orderBy('deleted_at', 'desc')->skip($data['skip'])->take(10)->get();
                
                $payload = "";
                foreach($archivedthreads as $thread) {
                    $thread_component = (new ActivityThread($thread, $user));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "hasNext"=> $user->archivedthreads->count() >  $data['skip'] + $data['range'],
                    "content"=>$payload,
                    "count"=>$archivedthreads->count()
                ];
                break;
            case "activity-log":
                break;
        }
    }
    public function generate_thread_component(Thread $thread) {
        $thread_component = (new IndexResource($thread));
        $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
        return $thread_component;
    }
}
