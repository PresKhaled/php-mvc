<?php

namespace App;

class Hash
{
    public static function password(string $value): string {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    public static function passwordVerify(string $password, string $hashedPassword): bool {
        return password_verify($password, $hashedPassword);
    }
}
