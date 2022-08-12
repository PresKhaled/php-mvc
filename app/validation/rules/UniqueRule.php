<?php

namespace App\validation\rules;

use App\contracts\RuleContract;
use Exception;

class UniqueRule implements RuleContract
{
    /**
     * @throws Exception
     */
    public function apply(string $field, mixed $value, string $rule, array $more = []): bool
    {
        $parts = explode(':', $rule);
        $tableWithNullableColumn = explode(',', $parts[1]);
        $table = $tableWithNullableColumn[0];
        $column = $tableWithNullableColumn[1] ??= $field;

        if (!isset($table) || !isset($column)) {
            throw new Exception;
        }

        $result = app()
            ->database
            ->rawQuery('SELECT ' . $column . ', COUNT(*) FROM ' . $table . ' GROUP BY ' . $column .' HAVING '. $column .' = '. "'$value'");

        // Result is "null".
        if (!isset($result[0])) {
            return true;
        }

        $count = ($result[0]['COUNT(*)'] ??= $result[0][1]);

        return ($count === 0);
    }

    public function message(string $field): string
    {
        return sprintf('The %s is already been taken.', $field);
    }
}
