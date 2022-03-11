<?php

namespace edgewizz\mtw;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class MtwServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Edgewizz\Mtw\Controllers\MtwController');
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
        $this->loadViewsFrom(__DIR__ . '/components', 'mtw');
        Blade::component('mtw::mtw.open', 'mtw.open');
        Blade::component('mtw::mtw.index', 'mtw.index');
        Blade::component('mtw::mtw.edit', 'mtw.edit');
    }
}
