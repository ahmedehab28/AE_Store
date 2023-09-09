<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;


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
        $this->registerPolicies();

        Gate::define('manage', function ($user) {
            return $user->is_admin;
        });

        Gate::define('same-user', function ($currentUser, $user) {
            return $currentUser->id == $user->id;
        });

        Gate::define('same-user-order', function ($user, $order) {
            return $user->id == $order->user_id;
        });
    }
}
