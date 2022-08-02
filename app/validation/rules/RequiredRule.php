<?php

namespace App\validation\rules;

use App\contracts\RuleContract;

class RequiredRule implements RuleContract
{
    public function apply(string $field, mixed $value, string $rule): bool
    {
        return isset($value);
    }

    public function message(string $field): string
    {
        return 'Required: default error message.';
    }
}
