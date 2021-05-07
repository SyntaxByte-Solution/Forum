<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Registering gates
        Gate::define('update.permissions', function (User $user) {
            return $user->has_role('owner');
        });

        Gate::define('role.permission.attach', function (User $user) {
            return $user->has_role('owner');
        });

        Gate::define('role.permission.detach', function (User $user) {
            return $user->has_role('owner');
        });
    }
}
