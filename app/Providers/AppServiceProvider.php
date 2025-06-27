<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if($this->app->environment('production')) {
            // Force HTTPS in production environment
            $this->app['request']->server->set('HTTPS', true);
        } else {
            // Force HTTP in non-production environments
            $this->app['request']->server->set('HTTPS', false);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
	    if($this->app->environment('production')) {
    		\URL::forceScheme('https');
	    } else {
            \URL::forceScheme('http');
        }
    }
}
