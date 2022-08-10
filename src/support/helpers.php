<?php

use App\Application;
use App\Config;
use App\View;
use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;
use Khaled\PhpMvc\http\Connection;
use Khaled\PhpMvc\support\Hash;
use Khaled\PhpMvc\support\WithArrayAccess;
use Minwork\Helper\Arr;

const FLASH_MESSAGES_KEY = 'flash_messages';
const OLD_VALUES_KEY = 'old_values';
const OLD_VALUES_NEVER_FLUSH = ['password', 'password_confirmation'];

if (!function_exists('app')) {
    /**
     * -
     *
     * @return Application|null
     */
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
    /**
     * -
     *
     * @return string
     */
    function base_path(): string
    {
        return __DIR__ . '/../../';
    }
}

if (!function_exists('views_path')) {
    /**
     * -
     *
     * @return string
     */
    #[Pure] function views_path(): string
    {
        return base_path() . '/views';
    }
}

if (!function_exists('parts_path')) {
    /**
     * -
     *
     * @return string
     */
    #[Pure] function parts_path(): string
    {
        return base_path() . '/views/layouts/parts';
    }
}

if (!function_exists('view')) {
    /**
     * -
     *
     * @throws Exception
     */
    #[NoReturn] function view(string $path, array $params = []): void
    {
        echo View::make($path, $params);
        exit;
    }
}

if (!function_exists('config_path')) {
    /**
     * -
     *
     * @return string
     */
    #[Pure] function config_path(): string
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
    function config(string $path): mixed
    {
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
    /**
     * -
     *
     * @param string $value
     * @return string
     */
    function app_str_class_format(string $value): string
    {
        $value = (explode(':', $value)[0]);
        $separator = '_';

        return str_replace($separator, '', ucwords($value, $separator));
    }
}

if (!function_exists('bcrypt')) {
    /**
     * -
     *
     * @param string $password
     * @return string
     */
    function bcrypt(string $password): string
    {
        return Hash::password($password);
    }
}

if (!function_exists('env')) {
    /**
     * -
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env(string $key, mixed $default = ''): mixed
    {
        return ($_ENV[$key] ??= $default);
    }
}

if (!function_exists('with_array_access')) {
    /**
     * -
     *
     * @param array $results
     * @return \Khaled\PhpMvc\support\WithArrayAccess
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
    /**
     * -
     *
     * @return Connection
     */
    function connection(): Connection
    {
        return app()->connection;
    }
}

if (!function_exists('back')) {
    /**
     * -
     *
     * @return void
     */
    #[NoReturn] function back(): void
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

if (!function_exists('old')) {
    /**
     * -
     *
     * @param string $name
     * @return string
     */
    function old(string $name): string
    {
        $keys = (FLASH_MESSAGES_KEY . '.' . OLD_VALUES_KEY . '.' . $name);

        if (app()->session->has($keys)) {
            return (app()->session->getFlash($name, OLD_VALUES_KEY));
        }

        return '';
    }
}
