<?php

namespace edgewizz\lamas;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class LamasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Edgewizz\Lamas\Controllers\LamasController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // dd($this);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__ . '/components', 'lamas');
        Blade::component('lamas::lamas.open', 'lamas.open');
        Blade::component('lamas::lamas.index', 'lamas.index');
        Blade::component('lamas::lamas.edit', 'lamas.edit');
    }
}
