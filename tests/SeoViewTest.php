<?php

namespace Gabrieliuga\LaravelSeoMetaBox\Tests;

use Giuga\LaravelSeoMetaBox\Http\View\MetaboxComposer;
use Giuga\LaravelSeoMetaBox\Models\Seo;
use Giuga\LaravelSeoMetaBox\Tests\TestCase;
use Giuga\LaravelSeoMetaBox\Tests\TestModelA;
use Giuga\LaravelSeoMetaBox\Tests\TestModelAWithDescription;
use Giuga\LaravelSeoMetaBox\Tests\TestModelAWithTitle;
use Giuga\LaravelSeoMetaBox\Tests\TestModelB;
use Illuminate\View\View;

class SeoViewTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Giuga\LaravelSeoMetaBox\LaravelSeoMetaBoxServiceProvider',
            'Giuga\LaravelSeoMetaBox\Tests\MockServiceProvider',
        ];
    }

    public function setUp(): void
    {
        parent::setUp();
        Seo::create(
            [
                'slug' => '/test',
                'title' => 'Example Title',
                'description' => 'Example Description',
                'type' => 'page',
            ]
        );
        TestModelA::insert([
            [
                'name' => 'Test 1',
                'slug' => 'test-1',
            ],
            [
                'name' => 'Test 2',
                'slug' => 'test-2',
            ],
            [
                'name' => 'Test 3',
                'slug' => 'test-3',
            ],
        ]);
    }

    /** @test */
    public function testProviderHasObjectOnPage()
    {
        TestModelA::where('slug', 'test-1')->first();
        TestModelA::where('slug', 'test-2')->first();
        $objectOnPage = TestModelA::where('slug', 'test-3')->first();
        $result = $this->app->make('laravel-seo-meta-box')->getObjectOnPage();
        $this->assertIsArray($result);
        $this->assertEquals($objectOnPage->id, $result['id']);
        $this->assertEquals("Giuga\LaravelSeoMetaBox\Tests\TestModelA", $result['type']);
    }

    /** @test */
    public function testRouteHasDefaultSeo()
    {
        $this->get('test-no-custom-seo')
            ->assertSee('<title>Laravel</title>', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertSee('<meta property="og:type" content="article" />', false);
    }

    /** @test */
    public function testRouteHasModelSeo()
    {
        $this->get('test')
            ->assertSee('<title>Example Title - Laravel</title>', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertSee('<meta property="og:description" content="Example Description" />', false)
            ->assertSee('<meta property="og:type" content="article" />', false);
    }

    /** @test */
    public function testRouteHasModelSeoForPaginatedRequest()
    {
        $this->get('test?page=2')
            ->assertSee('<title>Example Title - Laravel</title>', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertSee('<meta property="og:description" content="Example Description" />', false)
            ->assertSee('<meta property="og:type" content="article" />', false);
    }

    /** @test */
    public function testComposerReturnsNewData()
    {
        $composer = new MetaboxComposer();
        $this->assertInstanceOf(MetaboxComposer::class, $composer);
        $view = \view('test-seo-metabox::seo');
        $this->assertInstanceOf(View::class, $view);
        $composer->compose($view);

        $viewData = $view->getData();
        $this->assertIsArray($view->getData());
        $this->assertArrayHasKey('seoUseTwitter', $viewData);
        $this->assertArrayHasKey('seoTwitterHandle', $viewData);
        $this->assertArrayHasKey('seoTitle', $viewData);
        $this->assertArrayHasKey('seoDescription', $viewData);
        $this->assertArrayHasKey('seoUseOpenGraph', $viewData);
        $this->assertArrayHasKey('seoFullUrl', $viewData);
    }

    /** @test */
    public function testSeoHasDefaultTitle()
    {
        $this->cleanDB();
        TestModelAWithTitle::create([
            'name' => 'Test Name 1',
            'description' => 'Test description 1',
            'slug' => 'test-name-1',
        ]);
        $model = TestModelAWithTitle::where('slug', 'test-name-1')->first();
        $this->assertInstanceOf(TestModelAWithTitle::class, $model);
        $this->assertEquals('Test Name 1', $model->seo->title);
    }

    /** @test */
    public function testSeoHasUpdatedTitleAfterModelUpdate()
    {
        $this->cleanDB();
        TestModelAWithDescription::create([
            'name' => 'Test Name 1',
            'description' => 'Test description 1',
            'slug' => 'test-name-1',
        ]);
        $model = TestModelAWithDescription::where('slug', 'test-name-1')->first();
        $model->name = 'Test name 2';
        $model->save();

        $this->assertInstanceOf(TestModelAWithDescription::class, $model);
        $seoModel = Seo::where('type', get_class($model))->where('object_id', $model->id)->first();
        $this->assertEquals('Test name 2', $seoModel->title);
        $this->assertEquals('Test description 1', $seoModel->description);
    }

    /** @test */
    public function testSeoHasOriginalTitleAfterModelUpdate()
    {
        $this->cleanDB();
        TestModelAWithTitle::create([
            'name' => 'Test Name 1',
            'description' => 'Test description 1',
            'slug' => 'test-name-1',
        ]);
        $model = TestModelAWithTitle::where('slug', 'test-name-1')->first();
        $model->name = 'Test name 2';
        $model->save();

        $this->assertInstanceOf(TestModelAWithTitle::class, $model);
        $seoModel = Seo::where('type', get_class($model))->where('object_id', $model->id)->first();
        $this->assertEquals('Test Name 1', $seoModel->title);
    }

    private function cleanDB()
    {
        Seo::truncate();
        TestModelA::truncate();
        TestModelB::truncate();
        TestModelAWithTitle::truncate();
        TestModelAWithDescription::truncate();
    }
}
