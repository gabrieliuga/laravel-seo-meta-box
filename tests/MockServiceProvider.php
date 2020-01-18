<?php

namespace Giuga\LaravelSeoMetaBox\Tests;

use Giuga\LaravelSeoMetaBox\Http\View\MetaboxComposer;
use Giuga\LaravelSeoMetaBox\LaravelSeoMetaBox;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MockServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/data/views', 'test-seo-metabox');
        $this->loadRoutesFrom(__DIR__.'/data/routes.php');

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
