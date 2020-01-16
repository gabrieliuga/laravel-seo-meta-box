<?php

namespace Giuga\LaravelSeoMetaBox\Traits;

class SeoOptions
{
    public bool $hasSlug = false;
    public string $slugField;
    public string $routePrefix;

    public static function create(): self
    {
        return new static();
    }

    public function setSlugField(string $field): self
    {
        $this->hasSlug = true;
        $this->slugField = $field;

        return $this;
    }

    public function setRoutePrefix(string $prefix): self
    {
        $this->routePrefix = $prefix;

        return $this;
    }
}
