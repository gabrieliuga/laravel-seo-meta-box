<?php

namespace Giuga\LaravelSeoMetaBox;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Giuga\LaravelSeoMetaBox\LaravelSeoMetaBox::addObjectOnPage()
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
