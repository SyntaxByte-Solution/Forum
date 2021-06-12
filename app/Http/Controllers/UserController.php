<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\IsValidPassword;
use App\Models\{Thread, Category, User};
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function activities(Request $request, User $user) {
        $pagesize = 10;
        $pagesize_exists = false;
        $all = false;
        if($request->has('pagesize')) {
            $pagesize_exists = true;
            $pagesize = $request->input('pagesize');
        }

        $announcements = Category::where('slug', 'announcements')->pluck('id');

        $threads;
        if($pagesize == 'all') {
            $all = true;
            $threads = Thread::whereNotIn('category_id', $announcements)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')->lazy();
        } else {
            $threads = Thread::whereNotIn('category_id', $announcements)->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate($pagesize);
        }

        $discussions_count = $user->discussions_count();
        $questions_count = $user->questions_count();
        $posts_count = $user->posts_count();

        return view('user.activities')
            ->with(compact('user'))
            ->with(compact('discussions_count'))
            ->with(compact('questions_count'))
            ->with(compact('posts_count'))
            ->with(compact('pagesize'))
            ->with(compact('pagesize_exists'))
            ->with(compact('all'))
            ->with(compact('threads'));
    }

    public function profile(Request $request, User $user) {
        $discussions_count = $user->discussions_count();
        $questions_count = $user->questions_count();
        $posts_count = $user->posts_count();

        $recent_threads = $user->threads()
        ->orderBy('created_at', 'desc')->paginate(6);

        return view('user.profile')
            ->with(compact('user'))
            ->with(compact('discussions_count'))
            ->with(compact('questions_count'))
            ->with(compact('posts_count'))
            ->with(compact('recent_threads'));
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

        $firstname = $user->firstname;
        $lastname = $user->lastname;
        $username = $user->username;

        return view('user.settings.personal-settings')
            ->with(compact('username'))
            ->with(compact('user'));
    }

    public function edit_password(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        $username = $user->username;

        return view('user.settings.password-settings')
            ->with(compact('username'))
            ->with(compact('user'));
    }

    

    public function update(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);


        $data = $request->validate([
            'firstname'=>'sometimes|alpha|max:266',
            'lastname'=>'sometimes|alpha|max:266',
            'username'=> [
                'sometimes',
                'min:6',
                'max:256',
                Rule::unique('users')->ignore($user->id),   
            ],
            'about'=>'sometimes|max:1400',
            'avatar'=>'sometimes|file|image|mimes:jpg,gif,jpeg,bmp,svg,png|max:5000|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
            'cover'=>'sometimes|file|image|mimes:jpg,gif,jpeg,bmp,svg,png|max:5000|dimensions:min_width=50,min_height=50,max_width=1280,max_height=2050',
        ]);

        if($request->avatar_removed) {
            $data['avatar'] = null;
            $data['provider_avatar'] = null;
        }
        else if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store(
                'users/' . $user->id . '/avatars', 'public'
            );

            $data['avatar'] = $path;
        }

        if($request->cover_removed) {
            $data['cover'] = null;
        }
        else if($request->hasFile('cover')){
            $path = $request->file('cover')->store(
                'users/' . $user->id . '/covers', 'public'
            );

            $data['cover'] = $path;
        }

        $user->update($data);
        return redirect()->route('user.settings')->with('message','Profile updated successfully !');
    }

    public function update_personal(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        // dd($request);

        $data = $request->validate([
            'birth'=>'sometimes|nullable|date',
            'phone'=>'sometimes|nullable|max:266',
            'country'=>'sometimes|min:2|max:266',
            'city'=>'sometimes|min:2|max:266',
            'facebook'=>'sometimes|nullable|url',
            'instagram'=>'sometimes|nullable|min:2|max:266',
            'twitter'=>'sometimes|nullable|url',
        ]);

        $user->personal->update($data);
        return redirect()->route('user.personal.settings')->with('message','Profile information updated successfully !');
    }
    public function update_password(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        // dd($request);

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
        return redirect()->route('user.passwords.settings')->with('message','Your password is saved successfully. Now you can loggin using either your social network or usual login (email & password) !');
    }
    public function account_settings(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        // dd($request);
        return view('user.settings.account-settings')
        ->with(compact('user'));
    }

    public function delete_account(Request $request) {
        $user = auth()->user();
        $this->authorize('delete', $user);

        if(Hash::check($request->password, $user->password)) {
            // Here we need to delete all resources related to this user before deleting the user record
            $user->delete();
            return redirect('/home')->with('message', 'Your account is deactivated successfully !');
        } else {
            return redirect()->back()->with('error', 'Invalid password !');
        }
    }

    public function deactivate_account(Request $request) {
        $user = auth()->user();
        $this->authorize('delete', $user);

        $request->validate([
            'password'=>'required',
                'confirmed',
                'string',
                new IsValidPassword(),
        ]);

        if(Hash::check($request->password, $user->password)) {
            // Here we need to delete all resources related to this user before deleting the user record
            foreach($user->threads as $thread){
                foreach($thread->posts as $post) {
                    $post->delete();
                }
            }

            foreach($user->threads as $thread){
                $thread->delete();
            }

            // Here we chenge the user's account status from active to deactivated
            $user->set_account_status('deactivated');
            Auth::logout();
            return redirect("/home")->with('message', 'Your account is deactivated successfully !');
        } else {
            return redirect()->back()->with('errordeactiv', 'Invalid password !');
        }
    }

    public function activate_account() {
        $user = auth()->user();
        $this->authorize('activate_account', $user);

        if(!$user->account_deactivated()) {
            return redirect('/')->with('message', "You can't access account activation page because your account is already activated");
        }

        return view('user.settings.account-activation')
            ->with(compact('user'));
    }

    public function activating_account() {
        $user = auth()->user();
        $this->authorize('activate_account', $user);

        if($user->account_deactivated()) {
            $user->set_account_status('active');
            return redirect('/')->with('message', "Your account is activated successfully !");
        }

        abort(404);
    }

    public function username_check(Request $request) {
        $response = [
            'status'=>'valid',
            'message'=>'valid username',
            'valid'=>true
        ];

        if (Auth::user()) {
            if(Auth::user()->username == $request->username) {
                $response['status'] = 'yours';
                $response['message'] = 'valid username (yours)';
            } else if(User::where('username', $request->username)->where('id', '<>', Auth::user()->id)->count()) {
                $response = [
                    'status'=>'taken',
                    'message'=>'this username is already taken, choose another one',
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
}
