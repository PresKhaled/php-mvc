<?php

use App\Application;
use App\Config;
use App\View;
use App\WithArrayAccess;
use JetBrains\PhpStorm\NoReturn;
use Khaled\PhpMvc\http\Connection;
use Minwork\Helper\Arr;

if (!function_exists('app')) {
    function app(): ?Application
    {
        static $app = null;

        if (!$app) {
            $app = new Application;
        }

        return $app;
    }
}

if (!function_exists('base_path')) {
    function base_path(): string
    {
        return __DIR__ . '/../';
    }
}

if (!function_exists('views_path')) {
    function views_path(): string
    {
        return base_path() . '/views';
    }
}

if (!function_exists('parts_path')) {
    function parts_path(): string
    {
        return base_path() . '/views/layouts/parts';
    }
}

if (!function_exists('view')) {
    /**
     * @throws Exception
     */
    #[NoReturn] function view(string $path, array $params = []): void
    {
        echo View::make($path, $params);
        exit;
    }
}

if (!function_exists('config_path')) {
    function config_path(): string
    {
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

if (!function_exists('env')) {
    function env(string $key, mixed $default = ''): mixed {
        return ($_ENV[$key] ??= $default);
    }
}

if (!function_exists('with_array_access')) {
    /**
     * -
     *
     * @param array $results
     * @return WithArrayAccess
     */
    function with_array_access(array $results): WithArrayAccess
    {
        $withArrayAccess = (new class extends WithArrayAccess {
            public function __invoke(array $results)
            {
                parent::__construct($results);
            }
        });

        return $withArrayAccess($results);
    }
}

if (!function_exists('connection')) {
    function connection(): Connection
    {
        return app()->connection;
    }
}

if (!function_exists('back')) {
    #[NoReturn] function back(): void
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

if (!function_exists('old')) {
    function old(string $name): string
    {
        if (app()->session->has($name, true, true)) {
            return app()->session->get($name, true, true);
        }

        return '';
    }
}
