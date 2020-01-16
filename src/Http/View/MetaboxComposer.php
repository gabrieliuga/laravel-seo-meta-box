<?php

namespace Giuga\LaravelSeoMetaBox\Http\View;

use Giuga\LaravelSeoMetaBox\Models\Seo;
use Illuminate\View\View;

class MetaboxComposer
{
    private ?Seo $seo;
    private string $requestUrl;

    public function __construct()
    {
        $this->requestUrl = request()->getRequestUri();
        $this->seo = Seo::where('slug', $this->requestUrl)->first();
    }

    public function compose(View $view)
    {
        $title = config('app.name');
        if ($this->seo) {
            if ($this->seo->title) {
                $title = $this->seo->title;
                if (config('laravel-seo-meta-box.use_app_name')) {
                    $title .= config('laravel-seo-meta-box.use_app_name_separator') . config('app.name');
                }
            }
        }

        $view->with('seoUseTwitter', config('laravel-seo-meta-box.use_twitter'));
        $view->with('seoTwitterHandle', config('laravel-seo-meta-box.twitter_handle'));
        $view->with('seoTitle', $title);
        $view->with('seoDescription', $this->seo ? $this->seo->descroption : '');
        $view->with('seoUseOpenGraph', config('laravel-seo-meta-box.use_open_graph'));
        $view->with('seoFullUrl', url($this->requestUrl));
    }
}
