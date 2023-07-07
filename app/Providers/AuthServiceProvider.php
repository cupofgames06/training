<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Navbar;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        View::composer('*', function($view)
        {
            if(auth()->check() && Schema::hasTable('navbars')) {
                if(Cache::has('account'))
                {
                    $navbars = Navbar::whereNull('parent_id')->whereHas("roles", function ($q) {
                        $q->where('name', Cache::get('account')->route);
                    })->orderBy('ordering')->get();
                }
                else
                {
                    $navbars = Navbar::whereNull('parent_id')->whereHas("roles", function ($q) {
                        $q->whereIn('id', auth()->user()->roles()->first()->pluck('id'));
                    })->orderBy('ordering')->get();
                }

                $view->with('navbars', $navbars);
            }
        });
    }
}
