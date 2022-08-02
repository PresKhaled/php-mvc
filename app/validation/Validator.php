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
     * @return void
     */
    public function make(array $fullRules, array $data, ?array $messages = []): void
    {
        foreach ($fullRules as $field => $rules) {
            if (is_string($rules)) {
                $rules = explode('|', $rules);
            }

            foreach ($rules as $rule) {
                $namespace  = '\\App\\validation\\rules\\';
                $rule       = new ($namespace . (app_str_class_format($rule) . 'Rule'));
                $value      = ($data[$field] ??= null);
                $valid      = $rule->apply($field, $value);

                if (!$valid) {
                    $this->errors[$field][] = $messages[$field] ??= $rule->message($field);
                }
            }
        }
    }

    /**
     * -
     *
     * @return bool
     */
    public function hasErrors(): bool {
        return isset($this->errors);
    }
}
