<?php

namespace App\Util;

class Breadcrumbs
{
    private $crumbs = [];

    /**
     * @param string $name
     * @param string|null $url
     * @return void
     */
    public function add(string $name, ?string $url = null): void
    {
        $this->crumbs[] = [
            'name' => $name,
            'url' => $url,
        ];
    }

    /**
     * @return array
     */
    public function getCrumbs(): array
    {
        return $this->crumbs;
    }
}