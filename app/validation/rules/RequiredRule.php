<?php

namespace App\validation\rules;

use App\contracts\RuleContract;

class RequiredRule implements RuleContract
{
    public function apply(string $field, mixed $value, string $rule, array $more = []): bool
    {
        return (bool)$value;
    }

    public function message(string $field): string
    {
        return 'Required: default error message.';
    }
}
