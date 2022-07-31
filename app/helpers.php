<?php

use App\Application;
use App\View;

if (!function_exists('app')) {
    function app() {
        static $app = null;

        if (!$app) {
            $app = new Application;
        }

        return $app;
    }
}

if (!function_exists('base_path')) {
    function base_path() {
        return __DIR__ . '/../';
    }
}

if (!function_exists('views_path')) {
    function views_path() {
        return base_path() . '/views';
    }
}

if (!function_exists('view')) {
    function view(string $path, ?array $params) {
        return View::make($path, $params);
    }
}
