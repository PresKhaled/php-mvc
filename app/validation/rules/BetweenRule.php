<?php

namespace App\validation\rules;

use App\contracts\RuleContract;

class BetweenRule implements RuleContract
{
    public array $more = [];

    public function apply(string $field, mixed $value, string $rule, array $more = []): bool
    {
        $rule = explode(',', str_replace('between:', '', $rule));
        $length = strlen($value);
        $min = $rule[0];
        $max = $rule[1];

        $this->more[] = $min;
        $this->more[] = $max;

        return ($length >= $min && $length <= $max);
    }

    public function message(string $field): string
    {
        [$min, $max] = $this->more;

        return $field . " must be greater than or equals '$min' and less than or equals '$max'.";
    }
}
