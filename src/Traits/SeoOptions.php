<?php

namespace Giuga\LaravelSeoMetaBox\Traits;

class SeoOptions
{
    public bool $hasSlug = false;
    public string $slugField;
    public string $titleField;
    public string $descriptionField;
    public bool $overwriteOnUpdate = false;
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

    public function setTitleField(string $field): self
    {
        $this->titleField = $field;

        return $this;
    }

    public function setDescriptionField(string $field): self
    {
        $this->descriptionField = $field;

        return $this;
    }

    public function setOverwriteOnUpdate(bool $flag = true): self
    {
        $this->overwriteOnUpdate = $flag;

        return $this;
    }
}
