<?php

namespace App\contracts;

interface RuleContract
{
    public function apply(string $field, mixed $value, string $rule, array $more = []): bool;

    public function message(string $field): string;
}
