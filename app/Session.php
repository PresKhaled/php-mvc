<?php

namespace App;

use Minwork\Helper\Arr;

class Session
{
    public function __construct()
    {
        session_start();

        if (isset($_SESSION[FLASH_MESSAGES_KEY])) {
            Arr::each(
                $_SESSION[FLASH_MESSAGES_KEY],
                fn(string $key) => $_SESSION[FLASH_MESSAGES_KEY][$key]['remove'] = true,
                Arr::EACH_KEY_VALUE,
            );
        }
    }

    /**
     * -
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $in
     * @return void
     */
    public function set(string $key, mixed $value, string $in = null): void
    {
        if ($in) {
            $_SESSION[$in][$key] = $value;
            return;
        }

        $_SESSION[$key] = $value;
    }

    /**
     * -
     *
     * @param string $keys
     * @return bool
     */
    public function has(string $keys): bool
    {
        return Arr::has($_SESSION, $keys);
    }

    /**
     * -
     *
     * @param string $key
     * @param string|null $from
     * @return mixed
     */
    public function get(string $key, string $from = null): mixed
    {
        if ($from) {
            return ($_SESSION[$from][$key] ??= false);
        }

        return ($_SESSION[$key] ??= false);
    }

    /**
     * -
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $in
     * @return void
     */
    public function setFlash(string $key, mixed $value, string $in = null): void
    {
        if ($in) {
            $_SESSION[FLASH_MESSAGES_KEY][$in][$key] = $value;

            return;
        }

        $_SESSION[FLASH_MESSAGES_KEY][$key] = [
            'remove' => false,
            'content' => $value,
        ];
    }

    /**
     * -
     *
     * @param string $key
     * @param string|null $from
     * @return mixed
     */
    public function getFlash(string $key, string $from = null): mixed
    {
        if ($from) {
            return $_SESSION[FLASH_MESSAGES_KEY][$from][$key] ??= false;
        }

        return $_SESSION[FLASH_MESSAGES_KEY][$key]['content'] ??= false;
    }

    /**
     * -
     *
     * @param string $key
     * @param string|null $from
     * @return void
     */
    public function remove(string $key, string $from = null): void
    {
        if ($from) {
            unset($_SESSION[FLASH_MESSAGES_KEY][$from][$key]);
            return;
        }

        unset($_SESSION[FLASH_MESSAGES_KEY][$key]);
    }

    public function __destruct()
    {
        if (isset($_SESSION[FLASH_MESSAGES_KEY])) {
            Arr::each(
                $_SESSION[FLASH_MESSAGES_KEY],
                function (string $key, array $value) {
                    if (isset($value['remove']) && $value['remove']) {
                        $this->remove($key);
                    }
                },
                Arr::EACH_KEY_VALUE,
            );
        }
    }
}
