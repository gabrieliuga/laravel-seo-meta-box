# Add seo capabilities to your Laravel application

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gabrieliuga/laravel-seo-meta-box.svg?style=flat-square)](https://packagist.org/packages/gabrieliuga/laravel-seo-meta-box)
[![Build Status](https://img.shields.io/travis/gabrieliuga/laravel-seo-meta-box/master.svg?style=flat-square)](https://travis-ci.org/gabrieliuga/laravel-seo-meta-box)
[![Quality Score](https://img.shields.io/scrutinizer/g/gabrieliuga/laravel-seo-meta-box.svg?style=flat-square)](https://scrutinizer-ci.com/g/gabrieliuga/laravel-seo-meta-box)
[![Total Downloads](https://img.shields.io/packagist/dt/gabrieliuga/laravel-seo-meta-box.svg?style=flat-square)](https://packagist.org/packages/gabrieliuga/laravel-seo-meta-box)

Adds ability to create custom titles / description on a per page basis. Includes usage of Twitter handles and Open Graph data for social sharing.

## Installation

You can install the package via composer:

```bash
composer require gabrieliuga/laravel-seo-meta-box
```

## Usage

``` bash
artisan migrate

artisan vendor:publish --tag=metabox-config
```

```php
/**
* Manual entry
*/
Seo::create([
    'slug' => '/', //this is the page route 
    'title' => 'Super special application',
    'description' => 'My super special application that does x',
    'type' => 'page'
]);

/**
* Model based generator
*/

use Giuga\LaravelSeoMetaBox\Traits\HasSeo;
use Giuga\LaravelSeoMetaBox\Traits\SeoOptions;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasSeo;

    public function getSeoOptions(): SeoOptions
    {
        return SeoOptions::create()
            ->setSlugField('slug')
            ->setRoutePrefix('/page/');
    }
}

```

Change your application layout to include @metabox blade component

``` html
<head>
    @metabox
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
```
The output will be (with all options enabled)

```html
    <title>Super special application - Application Name</title>
    <meta name="description" content="My super special application that does x"/>
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@g_iuga">
    <meta name="twitter:title" content="Super special application - Application Name">
    <meta name="twitter:description" content="My super special application that does x">
    <meta name="twitter:creator" content="@g_iuga">
    <meta property="og:title" content="Super special application - Application Name" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://example.com" />
    <meta property="og:description" content="My super special application that does x" />
    <meta property="og:site_name" content="Application Name" />
```

### Testing

``` bash
phpunit
```

### View Customise

If you want to customize the output in any way, you can do so by publishing the view:

```bash
artisan vendor:publish --tag=metabox-views
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email me@iuga.dev instead of using the issue tracker.

## Credits

- [Gabriel Iuga](https://github.com/gabrieliuga)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
