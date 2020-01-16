    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{$seoDescription}}"/>
@if($seoUseTwitter)
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{{ $seoTwitterHandle }}">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{$seoDescription}}">
    <meta name="twitter:creator" content="{{ $seoTwitterHandle }}">
@endif
@if($seoUseOpenGraph)
    <meta property="og:title" content="{{ $seoTitle }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $seoFullUrl }}" />
    <meta property="og:description" content="{{ $seoDescription }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
@endif
