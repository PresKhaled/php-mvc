<?php

namespace Khaled\PhpMvc\http;

class Connection
{
    public function method(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function uri(): string {
        $uri = $_SERVER['REQUEST_URI'];

        return explode('?', $uri)[0] ?? $uri;
    }

    public function all(): array {
        return $_POST;
    }

    public function get(string $key): string
    {
        return $this->all()[$key] ??= '';
    }
}
