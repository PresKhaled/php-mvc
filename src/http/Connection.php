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
}
