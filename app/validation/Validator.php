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
     * @param array $attaches Enable a field to access the value of another field.
     * @return array
     */
    public function make(array $fullRules, array $data, ?array $messages = [], array $attaches = []): array
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
                $attachedField = $this->attachField($rawRule, $field, $attaches);

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
     * @param array $attaches
     * @return string
     */
    protected function attachField(string $rule, string $field, array $attaches): string
    {
        if ($rule === 'confirmed') {
            $attachedField = $field . '_confirmation';
        }

        if (array_key_exists($field, $attaches)) {
            $attachedField = $attaches[$field];
        }

        return ($attachedField ?? '');
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
