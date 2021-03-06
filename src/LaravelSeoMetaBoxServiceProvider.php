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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-seo-meta-box');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            // Publishing the config.
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('meta-box.php'),
            ], 'metabox-config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-seo-meta-box'),
            ], 'metabox-views');
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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'meta-box');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-seo-meta-box', function () {
            return new LaravelSeoMetaBox;
        });
    }
}
