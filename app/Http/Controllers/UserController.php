<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\{Thread, Category, User};

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
            ->with(compact('firstname'))
            ->with(compact('lastname'))
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
