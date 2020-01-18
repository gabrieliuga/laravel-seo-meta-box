<?php

namespace Gabrieliuga\LaravelSeoMetaBox\Tests;


use Giuga\LaravelSeoMetaBox\Tests\TestCase;

class ProviderTest extends TestCase
{
    /** @test */
    public function testAddObjectToPage()
    {
        $this->app->make('laravel-seo-meta-box')->addObjectOnPage('ModelClassA', 1);
        $this->app->make('laravel-seo-meta-box')->addObjectOnPage('ModelClassB', 2);
        $this->app->make('laravel-seo-meta-box')->addObjectOnPage('ModelClassC', 3);
        $this->app->make('laravel-seo-meta-box')->addObjectOnPage('ModelClassD', 4);

        $objectOnPage = $this->app->make('laravel-seo-meta-box')->getObjectOnPage();

        $this->assertIsArray($objectOnPage);
        $this->assertEquals('ModelClassD', $objectOnPage['type']);
        $this->assertEquals(4, $objectOnPage['id']);
    }
}
