<?php

namespace App\validation\rules;

use App\contracts\RuleContract;

class ConfirmedRule implements RuleContract
{
    public function apply(string $field, mixed $value, string $rule, array $more = []): bool
    {
        $attachedField = ($field . '_confirmation');
        $attachedFieldValue = $more[$attachedField];

        return ($value === $attachedFieldValue);
    }

    public function message(string $field): string
    {
        return $field;
    }
}
