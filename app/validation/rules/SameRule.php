<?php

namespace App\validation\rules;

use App\contracts\RuleContract;

class SameRule implements RuleContract
{
    protected string $field;
    protected string $sameAsField;

    public function apply(string $field, mixed $value, string $rule, array $more = []): bool
    {
        $this->field = $field;
        $this->sameAsField = (explode(':', $rule)[1] ??= '');

        return ($value === $more[$this->sameAsField]);
    }

    public function message(string $field): string
    {
        return sprintf('The field %s does not match the field %s.', $this->field, $this->sameAsField);
    }
}
