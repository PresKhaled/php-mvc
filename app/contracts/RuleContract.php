<?php

namespace App\contracts;

interface RuleContract
{
    public function apply(string $field, mixed $value): bool;

    public function message(string $field): string;
}
