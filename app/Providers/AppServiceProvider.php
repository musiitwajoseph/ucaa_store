<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Blade directive for permission checks
        Blade::if('hasPermission', function ($permission) {
            return auth()->check() && (auth()->user()->is_admin || auth()->user()->hasPermission($permission));
        });

        // Register Gate for permission checks (used by @can directive)
        Gate::before(function ($user, $ability) {
            // Admins can do everything
            if ($user->is_admin) {
                return true;
            }

            // Check if the ability matches a permission code
            if ($user->hasPermission($ability)) {
                return true;
            }

            // Return null to continue with other gates/policies
            return null;
        });
    }
}
