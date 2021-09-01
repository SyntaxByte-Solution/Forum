<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\IsValidPassword;
use App\Models\{Thread, Category, User, ProfileView, Like, Vote, Follow, AccountStatus};
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Classes\ImageResize;

class UserController extends Controller
{
    const PROFILE_THREADS_SIZE = 8;
    const PROFILE_THREADS_FETCH = 6;

    public function activities(Request $request, User $user) {
        $is_current = Auth::check() ? auth()->user()->id == $user->id : false;
        $announcements_ids = Category::where('slug', 'announcements')->pluck('id');
        // Take 6 threads created by the current user (the profile owner) to display as the first section in activities page
        $threads = Thread::whereNotIn('category_id', $announcements_ids)->where('user_id', $user->id)->orderBy('created_at', 'desc')->take(6)->get();

        $threads_count = $user->threads->count();

        return view('user.activities')
            ->with(compact('user'))
            ->with(compact('is_current'))
            ->with(compact('threads_count'))
            ->with(compact('threads'));
    }
    public function profile(Request $request, User $user) {
        if($user->account_status->id == 2) {
            return view('errors.custom.deactivated-account');
        }

        // --- profile view checking .. ---
        // We count only 1 profile view per day for the same user
        $found = ProfileView::
            where('created_at', '>', Carbon::now()->subHours(24)->toDateTimeString())
            ->where('visitor_ip', $request->ip())
            ->where('visited_id', $user->id)
            ->where('visitor_id', $profile_view->visitor_id)
            ->count();
        if(!$found) {
            $profile_view = new ProfileView;
            $profile_view = new ProfileView;
            $profile_view->visitor_ip = $request->ip();
            $profile_view->visited_id = $user->id;
            $profile_view->visitor_id = null;
            if($current_user = auth()->user()) {
                $profile_view->visitor_id = $current_user->id;
            }

            if(auth()->user()) {
                if($user->id != auth()->user()->id) {
                    $profile_view->save();
                }
            } else {
                $profile_view->save();
            }
        }

        // Check if the visitor is a follower of the visited profile
        $followed = false;
        if(Auth::check()) {
            $followed = (bool) Follow::where('follower', auth()->user()->id)
            ->where('followable_id', $user->id)
            ->where('followable_type', 'App\Models\User')
            ->count() > 0;
        }

        $threads = $user->threads()
            ->orderBy('created_at', 'desc')->paginate(self::PROFILE_THREADS_SIZE);
        $pagesize = self::PROFILE_THREADS_SIZE;

        $followers = $user->followers;
        $followers = $followers->map(function($item, $key) {
            return User::find($item->follower);
        })->take(8);

        $followed_users = $user->followed_users;
        $followed_users = $followed_users->map(function($item, $key) {
            return User::find($item->followable_id);
        })->take(8);

        return view('user.profile')
            ->with(compact('user'))
            ->with(compact('followers'))
            ->with(compact('followed_users'))
            ->with(compact('followed'))
            ->with(compact('pagesize'))
            ->with(compact('threads'));
    }
    public function edit(Request $request) {
        $user = auth()->user();
        $this->authorize('edit', $user);

        $firstname = $user->firstname;
        $lastname = $user->lastname;
        $username = $user->username;

        return view('user.settings.settings')
            ->with(compact('firstname'))
            ->with(compact('lastname'))
            ->with(compact('username'))
            ->with(compact('user'));
    }
    public function edit_personal_infos(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        return view('user.settings.personal-settings')
            ->with(compact('user'));
    }
    public function edit_password(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        return view('user.settings.password-settings')
            ->with(compact('user'));
    }
    public function account_settings(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        // dd($request);
        return view('user.settings.account-settings')
        ->with(compact('user'));
    }
    public function username_check(Request $request) {
        $response = [
            'status'=>'valid',
            'message'=>__('valid username'),
            'valid'=>true
        ];

        if (Auth::user()) {
            if(Auth::user()->username == $request->username) {
                $response['status'] = 'yours';
                $response['message'] = __('valid username (your current username)');
            } else if(User::where('username', $request->username)->where('id', '<>', Auth::user()->id)->count()) {
                $response = [
                    'status'=>'taken',
                    'message'=>__('this username is already taken, choose another one'),
                    'valid'=>false
                ];
            }
        } else {
            if(User::where('username', $request->username)->count()) {
                $response = [
                    'status'=>'taken',
                    'message'=>'this username is already taken, choose another one',
                    'valid'=>false
                ];
            }
        }

        $username = $request->validate([
            'username' => [
                'required',
                'min:6',
                'max:256',
                'alpha_dash'
            ]
        ]);

        return $response;
    }
    public function update(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);


        $data = $request->validate([
            'firstname'=>'required|alpha|max:266',
            'lastname'=>'sometimes|alpha|max:266',
            'username'=> [
                'required',
                'min:6',
                'max:256',
                Rule::unique('users')->ignore($user->id),   
            ],
            'about'=>'sometimes|max:1400',
            'avatar'=>'sometimes|file|image|mimes:jpg,gif,jpeg,bmp,png|max:5000|dimensions:min_width=200,min_height=200,max_width=1000,max_height=1000',
            'cover'=>'sometimes|file|image|mimes:jpg,gif,jpeg,bmp,png|max:8000|dimensions:min_width=200,min_height=200,max_width=1280,max_height=2050',
        ]);

        if($request->avatar_removed) {
            $data['provider_avatar'] = null;
            $data['avatar'] = null;
        }
        else if($request->hasFile('avatar')){
            $path = $request->file('avatar')->storeAs(
                'users/' . $user->id. '/usermedia/avatars', 'avatar.png', 'public'
            );

            $avatar_dims = [[26, 30], [36, 30], [36, 100], [100, 50], [100, 100], [160, 50], [160, 100], [200, 60], [200, 100], [300, 70], [300, 100], [400, 80], [400, 100]];
            
            $src = 'users/'. $user->id. '/usermedia/avatars/avatar.png';
            foreach($avatar_dims as $avatar_dim) {
                // *** 1) Initialise / load image
                $resizeObj = new ImageResize($src);
    
                // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                $resizeObj -> resizeImage($avatar_dim[0], $avatar_dim[0], 'crop');

                $destination = 'users/' . $user->id . '/usermedia/avatars/' . $avatar_dim[0] . '-l.png';
                if($avatar_dim[1] == 100) {
                    $destination = 'users/' . $user->id . '/usermedia/avatars/' . $avatar_dim[0] . '-h.png';
                }

                // *** 3) Save image ('image-name', 'quality [int]')
                $resizeObj->saveImage($destination, $avatar_dim[1]);
            }

            $data['avatar'] = $path;
            // Here we need to notify all the followers about avatar change
            foreach($user->followers as $follower) {
                $follower = User::find($follower->follower);
                // First delete followers notifications about a previous avatar change if exists
                foreach($follower->notifications as $notification) {
                    if($notification->data['action_type'] == "avatar-change" 
                    && $notification->data['action_user'] == $user->id
                    && $notification->data['action_resource_id'] == $user->id) {
                        $notification->delete();
                    }
                }
                
                $follower->notify(
                    new \App\Notifications\UserAction([
                        'action_user'=>auth()->user()->id,
                        'action_statement'=>"changed his profile avatar",
                        'resource_string_slice'=>"",
                        'action_type'=>'avatar-change',
                        'action_date'=>now(),
                        'action_resource_id'=>auth()->user()->id,
                        'action_resource_link'=>route('user.profile', ['user'=>auth()->user()->username]),
                    ])
                );
            }
        }

        if($request->cover_removed) {
            $data['cover'] = null;
        }
        else if($request->hasFile('cover')){
            $path = $request->file('cover')->storeAs(
                'users/' . $user->id. '/usermedia/covers', 'cover.png', 'public'
            );

            $data['cover'] = $path;

            foreach($user->followers as $follower) {
                $follower = User::find($follower->follower);
                
                $follower->notify(
                    new \App\Notifications\UserAction([
                        'action_user'=>auth()->user()->id,
                        'action_statement'=>"changed his profile cover",
                        'resource_string_slice'=>"",
                        'action_type'=>'image-action',
                        'action_date'=>now(),
                        'action_resource_id'=>auth()->user()->id,
                        'action_resource_link'=>route('user.profile', ['user'=>auth()->user()->username]),
                    ])
                );
            }
        }

        $user->update($data);
        return redirect()->route('user.settings')->with('message', __('Your profile settings has been updated successfully') . '!');
    }
    public function update_personal(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        $data = $request->validate([
            'birth'=>'sometimes|nullable|date',
            'phone'=>'sometimes|nullable|max:266',
            'country'=>'sometimes|alpha|min:2|max:266',
            'city'=>'sometimes|alpha|min:2|max:266',
            'facebook'=>'sometimes|nullable|url',
            'instagram'=>'sometimes|nullable|min:2|max:266',
            'twitter'=>'sometimes|nullable|url',
        ]);

        $user->personal->update($data);
        return redirect()->route('user.personal.settings')->with('message',__('Your profile informations has been updated successfully !'));
    }
    public function update_password(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        $data = $request->validate([
            'password' => [
                'required',
                'confirmed',
                'string',
                new IsValidPassword(),
            ]
        ]);
        $data['password'] = Hash::make($data['password']);
        
        $user->update($data);

        return redirect()->route('user.passwords.settings')->with('message', __('Your password is saved successfully. Now you can loggin using either your social network or usual login (email & password) !'));
    }
    public function delete_account(Request $request) {
        $user = auth()->user();
        $this->authorize('delete', $user);

        if(Hash::check($request->password, $user->password)) {
            $user->delete();

            Auth::logout();
            return redirect("/home")->with('message', __('Your account has been deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Invalid password'));
        }
    }
    public function deactivate_account(Request $request) {
        $user = auth()->user();
        $this->authorize('delete', $user);

        $data = $request->validate([
            'password'=>'required',
                'confirmed',
                'string',
                new IsValidPassword(),
        ]);

        if(Hash::check($request->password, $user->password)) {
            // Here we chenge the user's account status from active to deactivated
            $user->set_account_status('deactivated');

            Auth::logout();
            return redirect("/")->with('message', __('Your account is deactivated successfully !'));
        } else {
            return redirect()->back()->with('errordeactiv', 'Invalid password !');
        }
    }
    public function activate_account() {
        $this->authorize('activate_account');

        return view('user.settings.account-activation')
            ->with(compact('user'));
    }
    public function activating_account() {
        $this->authorize('activate_account');

        if($user->account_deactivated()) {
            $user->set_account_status('active');
            return redirect('/')->with('message', __("Your account is activated successfully !"));
        }
        
        abort(404);
    }
}
