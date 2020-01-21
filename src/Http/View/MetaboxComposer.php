<?php

namespace Giuga\LaravelSeoMetaBox\Http\View;

use Giuga\LaravelSeoMetaBox\Models\Seo;
use Illuminate\View\View;

class MetaboxComposer
{
    private ?Seo $seo = null;
    private string $requestUrl;

    public function __construct()
    {
        $this->requestUrl = request()->getRequestUri();
        $query = request()->getQueryString();
        if ($query !== null) {
            $query = '?'.$query;
        }
        $this->seo = Seo::where('slug', $this->requestUrl)->first();
        if (! $this->seo) {
            $this->seo = Seo::where('slug', str_replace($query, '', $this->requestUrl))->first();
            if (! $this->seo) {
                $metaBox = app()->make('laravel-seo-meta-box')->getObjectOnPage();
                if ($metaBox) {
                    $this->seo = Seo::where('type', $metaBox['type'])->where('object_id', $metaBox['id'])->first();
                }
            }
        }
    }

    public function compose(View $view)
    {
        $title = config('app.name');
        if ($this->seo) {
            if ($this->seo->title) {
                $title = $this->seo->title;
                if (config('meta-box.use_app_name')) {
                    $title .= config('meta-box.use_app_name_separator').config('app.name');
                }
            }
        }

        $view->with('seoUseTwitter', config('meta-box.use_twitter'));
        $view->with('seoTwitterHandle', config('meta-box.twitter_handle'));
        $view->with('seoTitle', $title);
        $view->with('seoDescription', $this->seo ? $this->seo->description : '');
        $view->with('seoUseOpenGraph', config('meta-box.use_open_graph'));
        $view->with('seoFullUrl', url($this->requestUrl));
    }
}
