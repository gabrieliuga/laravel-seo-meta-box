<?php

namespace Giuga\LaravelSeoMetaBox;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Gabrieliuga\LaravelSeoMetaBox\Skeleton\SkeletonClass
 */
class LaravelSeoMetaBoxFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-seo-meta-box';
    }
}
