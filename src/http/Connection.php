<?php

namespace Khaled\PhpMvc\http;

use JetBrains\PhpStorm\Pure;

class Connection
{
    /**
     * -
     *
     * @return string
     */
    public function method(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * -
     *
     * @return string
     */
    public function uri(): string {
        $uri = $_SERVER['REQUEST_URI'];

        return explode('?', $uri)[0] ?? $uri;
    }

    /**
     * -
     *
     * @return array
     */
    public function all(): array {
        return $_POST;
    }

    /**
     * -
     *
     * @param string $key
     * @return mixed
     */
    #[Pure] public function get(string $key): mixed
    {
        return $this->all()[$key] ??= '';
    }
}
