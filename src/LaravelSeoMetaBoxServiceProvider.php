<?php

namespace Giuga\LaravelSeoMetaBox;

use Giuga\LaravelSeoMetaBox\Http\View\MetaboxComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LaravelSeoMetaBoxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-seo-meta-box');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-seo-meta-box');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('meta-box.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-seo-meta-box'),
            ], 'views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-seo-meta-box'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-seo-meta-box'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

        Blade::include('laravel-seo-meta-box::seo', 'metabox');

        View::composer(
            'laravel-seo-meta-box::seo', MetaboxComposer::class
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-seo-meta-box');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-seo-meta-box', function () {
            return new LaravelSeoMetaBox;
        });
    }
}
