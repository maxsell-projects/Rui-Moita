<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Admin gate
        Gate::define('isAdmin', function (User $user) {
            return $user->isAdmin();
        });

        // Can manage properties gate
        Gate::define('manageProperties', function (User $user) {
            return $user->canManageProperties();
        });
    }
}
