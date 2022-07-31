<?php

namespace App;

use Exception;

class View
{
    /**
     *
     *
     * @throws Exception
     */
    public static function make(string $path, array $params = []): bool|string
    {
        $path = (views_path() . '/' . str_replace('.', '/', $path));

        if (is_dir($path)) {
            $path .= '/index';
        }

        if (!is_file($path .= '.php')) {
            throw new Exception("Target view (file): '$path' not found.");
        }

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        require_once $path;

        return ob_get_contents();
    }
}
