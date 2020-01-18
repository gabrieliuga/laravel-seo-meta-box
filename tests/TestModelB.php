<?php

namespace Giuga\LaravelSeoMetaBox\Tests;

use Giuga\LaravelSeoMetaBox\Traits\HasSeo;
use Giuga\LaravelSeoMetaBox\Traits\SeoOptions;
use Illuminate\Database\Eloquent\Model;

class TestModelB extends Model
{
    use HasSeo;
    protected $table = 'test_model_b';
    protected $guarded = [];
    public $timestamps = false;

    public function getSeoOptions(): SeoOptions
    {
        return SeoOptions::create()
            ->setRoutePrefix('/modal_b/');
    }
}
