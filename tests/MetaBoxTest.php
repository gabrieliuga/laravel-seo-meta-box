<?php

namespace Gabrieliuga\LaravelSeoMetaBox\Tests;

use Giuga\LaravelSeoMetaBox\Models\Seo;
use Giuga\LaravelSeoMetaBox\Tests\TestCase;
use Giuga\LaravelSeoMetaBox\Tests\TestModelA;
use Giuga\LaravelSeoMetaBox\Tests\TestModelB;
use Illuminate\Support\Str;

class MetaBoxTest extends TestCase
{
    /** @test */
    public function testModelHasSeo()
    {
        $modelA = new TestModelA();
        $modelA->name = 'Test Example';
        $modelA->slug = Str::slug($modelA->name);
        $modelA->save();

        $this->assertInstanceOf(Seo::class, $modelA->seo);
        $this->assertTrue($modelA->seo->object_id == $modelA->id);
        $this->assertStringContainsString($modelA->slug, $modelA->seo->slug);
    }

    /** @test */
    public function testModelUpdatesSlug()
    {
        $modelA = new TestModelA();
        $modelA->name = 'Test Example 2';
        $modelA->slug = Str::slug($modelA->name);
        $modelA->save();

        $this->assertTrue($modelA->seo->object_id == $modelA->id);
        $this->assertStringContainsString($modelA->slug, $modelA->seo->slug);

        $modelA->slug = 'a-new-slug';
        $modelA->save();

        /**
         * Model relationship won't show the new slug so grab it from the database.
         */
        $this->assertStringContainsString('a-new-slug', Seo::find($modelA->seo->id)->slug);
    }

    /** @test */
    public function testModelBWithoutSlug()
    {
        $modelB = new TestModelB();
        $modelB->name = 'Test Example 1';
        $modelB->save();

        $this->assertTrue($modelB->seo->object_id == $modelB->id);
    }

    /** @test */
    public function testModel2ModelsWithTheSameID()
    {
        $modelB = new TestModelB();
        $modelB->name = 'Test Example 1';
        $modelB->save();

        $modelA = new TestModelA();
        $modelA->name = 'Test Example 2';
        $modelA->save();

        $this->assertTrue($modelB->seo->id != $modelA->seo->id);
        $this->assertTrue($modelB->id == $modelA->id);
        $this->assertTrue($modelA->seo->title == $modelB->seo->title);
    }
}
