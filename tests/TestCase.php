<?php

namespace Giuga\LaravelSeoMetaBox\Tests;

use Giuga\LaravelSeoMetaBox\LaravelSeoMetaBoxServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSeoMetaBoxServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        Schema::dropAllTables();

        include_once __DIR__.'/../database/migrations/2020_01_12_215032_create_seo_tables.php';

        (new \CreateSeoTables())->up();

        $app['db']->connection()->getSchemaBuilder()->create('test_model_a', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('slug')->nullable();
        });

        $app['db']->connection()->getSchemaBuilder()->create('test_model_b', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
        });
    }
}
