<?php

namespace App;

class Session
{
    protected const FLASH_MESSAGES_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
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
            return ($_SESSION[$this::FLASH_MESSAGES_KEY][$key] ??= false);
        }

        return ($_SESSION[$key] ??= false);
    }

    public function flash(string $key, mixed $value): void
    {
        $_SESSION[$this::FLASH_MESSAGES_KEY][$key] = $value;
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
        $_SESSION[$this::FLASH_MESSAGES_KEY] = [];
    }
}
