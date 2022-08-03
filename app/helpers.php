<?php

use App\Application;
use App\Config;
use App\View;
use Minwork\Helper\Arr;

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

if (!function_exists('config_path')) {
    function config_path() {
        return base_path() . '/config';
    }
}

if (!function_exists('config')) {
    /**
     * Get the value of the given key or return the full configuration array.
     *
     * @return mixed|array
     * @throws Exception
     */
    function config(string $path): mixed {
        $parts = explode('.', $path);
        $fileBasename = $parts[0] ??= $path; // Specified key(s) or not.
        $filePath = (config_path() . '/' . $fileBasename . '.php');

        if (!is_file($filePath)) {
            throw new Exception("File not found: ($filePath).");
        }

        $specifiedConfig = include $filePath;

        if (!is_array($specifiedConfig)) {
            throw new Exception('The configuration file should return an array.');
        }

        $keys = implode('.', Arr::remove($parts, 0));
        $config = new Config($specifiedConfig);

        if ($keys && $config->offsetExists($keys)) {
            return $config->offsetGet($keys);
        }

        return $config;
    }
}

if (!function_exists('app_str_class_format')) {
    function app_str_class_format(string $value): string {
        $value      = (explode(':', $value)[0]);
        $separator  = '_';

        return str_replace($separator, '', ucwords($value, $separator));
    }
}

/*if (!function_exists('when')) {
    function when(mixed $value, mixed $conditions): bool {
        if ($conditions) {
            return $value;
        }
    }
}*/
