<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.base', 'App\Http\ViewComposer\TermosCondicoesComposer');
        view()->composer('includes.main-search', 'App\Http\ViewComposer\TipoAtendimentosComposer');
        view()->composer('resultado', 'App\Http\ViewComposer\TipoAtendimentosComposer');
        view()->composer('checkup.resultado', 'App\Http\ViewComposer\TipoAtendimentosComposer');
        view()->composer('includes.checkup-section-landing', 'App\Http\ViewComposer\CheckupSectionLandingComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//      	$this->app->singleton(Permissao::class);
//     	$this->app->singleton('App\Http\Controllers\PermissaoController', function ($app) {
//     		return new App\Http\Controllers\PermissaoController($app->make('ObjPermissao'));
//     	});
    }
}
