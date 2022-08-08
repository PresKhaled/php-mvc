<?php

namespace App;

use Minwork\Helper\Arr;

class Session
{
    protected const FLASH_MESSAGES_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();

        $removableFlashMessages = array_filter($_SESSION[$this::FLASH_MESSAGES_KEY], fn(array $value) => !$value['remove']);

        Arr::each(
            $removableFlashMessages,
            fn(string $key) => $_SESSION[$this::FLASH_MESSAGES_KEY][$key]['remove'] = true,
            Arr::EACH_KEY_VALUE,
        );
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key, bool $flash = false): bool
    {
        if ($flash) {
            return isset($_SESSION[$this::FLASH_MESSAGES_KEY][$key]);
        }

        return isset($_SESSION[$key]);
    }

    public function get(string $key, bool $flash = false): mixed
    {
        if ($flash) {
            return ($_SESSION[$this::FLASH_MESSAGES_KEY][$key]['content'] ??= false);
        }

        return ($_SESSION[$key] ??= false);
    }

    public function flash(string $key, mixed $value): void
    {
        $_SESSION[$this::FLASH_MESSAGES_KEY][$key] = [
            'remove' => false,
            'content' => $value,
        ];
    }

    public function remove(string $key, bool $flash = false): void
    {
        if ($flash) {
            unset($_SESSION[$this::FLASH_MESSAGES_KEY][$key]);
            return;
        }

        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        Arr::each(
            $_SESSION[$this::FLASH_MESSAGES_KEY],
            function (string $key, array $value) {
                if ($value['remove']) {
                    $this->remove($key, true);
                }
            },
            Arr::EACH_KEY_VALUE,
        );
    }
}
