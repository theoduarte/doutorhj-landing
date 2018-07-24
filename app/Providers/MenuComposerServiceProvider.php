<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.master', 'App\Http\ViewComposer\MenuComposer');
        view()->composer('layouts.base', 'App\Http\ViewComposer\MenuComposer');
        view()->composer('layouts.base', 'App\Http\ViewComposer\TermosCondicoesComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
