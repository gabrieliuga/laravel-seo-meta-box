<?php

namespace Giuga\LaravelSeoMetaBox;

class LaravelSeoMetaBox
{
    private array $objectsOnPage = [];

    public function addObjectOnPage(string $type, int $id): void
    {
        $this->objectsOnPage[] = [
            'type' => $type,
            'id' => $id,
        ];
    }

    /**
     * Retrieve the last object added to the page that can have Seo.
     */
    public function getObjectOnPage(): ?array
    {
        if (count($this->objectsOnPage)) {
            return end($this->objectsOnPage);
        }

        return null;
    }
}
