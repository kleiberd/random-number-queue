<?php

declare(strict_types=1);

namespace App\Framework\Routing\RouteCollection;

class RouteCollection implements \ArrayAccess
{
    private $items;

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset): RouteCollectionItem
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }
}
