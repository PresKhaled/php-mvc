<?php

namespace Khaled\PhpMvc\support;

class Hash
{
    /**
     * -
     *
     * @param string $value
     * @return string
     */
    public static function password(string $value): string
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    /**
     * -
     *
     * @param string $password
     * @param string $hashedPassword
     * @return bool
     */
    public static function passwordVerify(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}
