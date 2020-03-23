<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\ModuleRight;
use App\Policies\ModulePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        // 'App\User' => 'App\Policies\UserPolicy',
        ModuleRight::class => ModulePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('isAccountant', function ($user) {
            return $user->isAccountant();
        });
        Gate::define('isMerchant', function ($user) {
            return $user->isMerchant();
        });

        Gate::define('canAccessPage', function ($user, $role_id, $module){
            return $user->hasAccess($role_id, $module);
            // return $module == "User Management";
        });
    }

    
}
