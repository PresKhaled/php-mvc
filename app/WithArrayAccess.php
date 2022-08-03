<?php

namespace App;

use ArrayAccess;
use Minwork\Helper\Arr;

class WithArrayAccess implements ArrayAccess
{
    protected static array $items = [];

    public function __construct(array $items)
    {
        self::$items = $items;
    }

    public function offsetExists(mixed $offset): bool
    {
        return Arr::has(self::$items, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return Arr::get(self::$items, $offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        self::$items = Arr::set(self::$items, $offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        self::$items = Arr::remove(self::$items, $offset);
    }

    // --------------------- Aliases for methods --------------------- //

    public function exists(mixed $offset): bool {
        return self::offsetExists($offset);
    }

    public function get(mixed $offset): mixed {
        return self::offsetGet($offset);
    }

    public function set(mixed $offset, mixed $value): void {
        self::offsetSet($offset, $value);
    }

    public function unset(mixed $offset): void {
        self::offsetUnset($offset);
    }
}
