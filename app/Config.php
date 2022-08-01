<?php

namespace App;

use ArrayAccess;
use Minwork\Helper\Arr;

class Config implements ArrayAccess
{
    protected array $items = [];

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function offsetExists(mixed $offset): bool
    {
        return Arr::has($this->items, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return Arr::get($this->items, $offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->items = Arr::set($this->items, $offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->items = Arr::remove($this->items, $offset);
    }

    // --------------------- Aliases for methods --------------------- //

    public function exists(mixed $offset): bool {
        return $this->offsetExists($offset);
    }

    public function get(mixed $offset): mixed {
        return $this->offsetGet($offset);
    }

    public function set(mixed $offset, mixed $value): void {
        $this->offsetSet($offset, $value);
    }

    public function unset(mixed $offset): void {
        $this->offsetUnset($offset);
    }
}
