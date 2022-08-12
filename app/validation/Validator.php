<?php

namespace App\validation;

class Validator
{
    public array $errors = [];

    /**
     * -
     *
     * @param array $fullRules
     * @param array $data
     * @param array|null $messages
     * @return array
     */
    public function make(array $fullRules, array $data, ?array $messages = []): array
    {
        $validated = [];

        foreach ($fullRules as $field => $rules) {
            $value = ($data[$field] ??= null);

            if (is_string($rules)) {
                $rules = explode('|', $rules);
            }

            foreach ($rules as $rawRule) {
                $namespace = '\\App\\validation\\rules\\';
                $rule = new ($namespace . (app_str_class_format($rawRule) . 'Rule'));
                $attachedField = $this->attachField($rawRule, $field);

                if ($attachedField) {
                    $more = [$attachedField => ($data[$attachedField] ??= '')];
                }

                $valid = $rule->apply($field, $value, $rawRule, ($more ?? []));

                if (!$valid) {
                    $this->errors[$field][] = ($messages[$field] ??= $rule->message($field));
                    continue;
                }
            }

            // Avoid adding the field to the validated array if the field has another invalid rule.
            if (!isset($this->errors[$field])) {
                $validated[$field] = $value;
            }
        }

        return $validated;
    }

    /**
     * -
     *
     * @param string $rule
     * @param string $field
     * @return string
     */
    protected function attachField(string $rule, string $field): string
    {
        $rule = (($parts = explode(':', $rule))[0]);

        return match($rule) {
            'confirmed' => ($field . '_confirmation'),
            'same' => $parts[1],
            default => '',
        };
    }

    /**
     * -
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
