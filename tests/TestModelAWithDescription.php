<?php

namespace Giuga\LaravelSeoMetaBox\Tests;

use Giuga\LaravelSeoMetaBox\Traits\HasSeo;
use Giuga\LaravelSeoMetaBox\Traits\SeoOptions;
use Illuminate\Database\Eloquent\Model;

class TestModelAWithDescription extends Model
{
    use HasSeo;
    protected $table = 'test_model_a';
    protected $guarded = [];
    public $timestamps = false;

    public function getSeoOptions(): SeoOptions
    {
        return SeoOptions::create()
            ->setSlugField('slug')
            ->setRoutePrefix('/modal_a/')
            ->setTitleField('name')
            ->setDescriptionField('description')
            ->setOverwriteOnUpdate();
    }
}
