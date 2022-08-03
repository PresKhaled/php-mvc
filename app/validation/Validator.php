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
     * @return void
     */
    public function make(array $fullRules, array $data, ?array $messages = [], array $attaches = []): void
    {
        foreach ($fullRules as $field => $rules) {
            if (is_string($rules)) {
                $rules = explode('|', $rules);
            }

            foreach ($rules as $rawRule) {
                $namespace = '\\App\\validation\\rules\\';
                $rule = new ($namespace . (app_str_class_format($rawRule) . 'Rule'));
                $value = ($data[$field] ??= null);
                $attachedField = $this->attachField($rawRule, $field, $attaches);

                if ($attachedField) {
                    $more = [$attachedField => $data[$attachedField]];
                }

                $valid = $rule->apply($field, $value, $rawRule, ($more ?? []));

                if (!$valid) {
                    $this->errors[$field][] = $messages[$field] ??= $rule->message($field);
                }
            }
        }
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
        return isset($this->errors);
    }
}
