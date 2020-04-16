<?php

namespace App\Providers;

use App\Bin\Auth\AuthManager;
use App\Bin\Auth\Token;
use App\Bin\Auth\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\{Gate};

class AuthServiceProvider extends ServiceProvider
{


    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }

    public function register()
    {
        $this->app->singleton('Auth', function()
        {
            $userModel = new User();
            $tokenModel = new Token();
            $request = app(\Illuminate\Http\Request::class);
            return new AuthManager($userModel, $request, $tokenModel);
        });
    }
}
