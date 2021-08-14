<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\{Thread, EmojiFeedback, Vote};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.default');
        Paginator::defaultSimpleView('vendor.pagination.simple-default');
        Blade::if('canemoji', function () {
            $ip = request()->ip();
            if(Auth::check()) {
                return EmojiFeedback::where('user_id', Auth::id())->where('created_at', '>', today())->count() == 0;
            } else {
                return EmojiFeedback::where('ip', $ip)->where('created_at', '>', today())->count() == 0;
            }
        });
        Blade::if('upvoted', function ($resource, $type) {
            if($user=auth()->user()) {
                return Vote::where('vote', '1')
                        ->where('user_id', $user->id)
                        ->where('votable_id', $resource->id)
                        ->where('votable_type', $type)
                        ->count() > 0;
            } else {
                return false;
            }
        });
        Blade::if('downvoted', function ($resource, $type) {
            if($user=auth()->user()) {
                return Vote::where('vote', '-1')
                        ->where('user_id', $user->id)
                        ->where('votable_id', $resource->id)
                        ->where('votable_type', $type)
                        ->count() > 0;
            } else {
                return false;
            }
        });
        if (($lang = Cookie::get('lang')) !== null) {
            App::setLocale($lang);
        }
        Schema::defaultStringLength(191);
    }
}
