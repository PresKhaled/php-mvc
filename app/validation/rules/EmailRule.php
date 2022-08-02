<?php

namespace App\validation\rules;

use App\contracts\RuleContract;

class EmailRule implements RuleContract
{

    public function apply(string $field, mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function message(string $field): string
    {
        return $field . ' is invalid.';
    }
}
