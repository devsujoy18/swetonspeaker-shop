<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define your Gates here
        Gate::define('isAdmin', function (User $user) {
            return $user->user_type === 'admin';
        });

        Gate::define('isSubadmin', function (User $user) {
            return $user->user_type === 'sub-admin';
        });
        
        Gate::define('isUser', function (User $user) {
            return $user->user_type === 'user';
        });

        // You can add more gates as needed, e.g., for specific permissions
        // Gate::define('manage-products', function (User $user) {
        //     return $user->user_type === 'admin' || $user->user_type === 'editor';
        // });
    }
}