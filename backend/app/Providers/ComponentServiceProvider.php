<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ComponentService;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ComponentService::class, function($app): ComponentService{
            return new ComponentService();
        })
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
