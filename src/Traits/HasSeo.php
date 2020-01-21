<?php

namespace Giuga\LaravelSeoMetaBox\Traits;

use Giuga\LaravelSeoMetaBox\Models\Seo;
use Illuminate\Database\Eloquent\Model;

trait HasSeo
{
    abstract public function getSeoOptions(): SeoOptions;

    protected static function bootHasSeo()
    {
        static::saved(function (Model $model) {
            $options = $model->getSeoOptions();
            $seo = Seo::firstOrNew([
                'type' => get_class($model),
                'object_id' => $model->{$model->primaryKey},
            ]);
            $seo->slug = $options->routePrefix ?? '';
            if ($options->hasSlug) {
                $seo->slug .= $model->{$options->slugField};
            } else {
                $seo->slug .= $model->{$model->primaryKey};
            }
            if ((empty($seo->title) || $options->overwriteOnUpdate) && isset($options->titleField)) {
                $seo->title = $model->{$options->titleField};
            }
            if ((empty($seo->description) || $options->overwriteOnUpdate) && isset($options->descriptionField)) {
                $seo->description = $model->{$options->descriptionField};
            }
            $seo->save();
        });

        static::retrieved(function (Model $model) {
            app()->make('laravel-seo-meta-box')->addObjectOnPage(get_class($model), $model->{$model->primaryKey});
        });
    }

    public function seo()
    {
        return $this->hasOne(Seo::class, 'object_id');
    }
}
