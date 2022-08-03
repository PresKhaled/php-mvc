<?php

namespace Khaled\PhpMvc\database\grammers;

use App\Model;

class MysqlGrammer
{
    public static function buildCreateQuery(array $columns): string
    {
        $length = count($columns);
        $columns = implode(', ', $columns);
        $placeholders = rtrim(str_repeat('?, ', $length), ', ');

        return ('INSERT INTO ' . Model::getTableName() . " ($columns) VALUES($placeholders)");
    }

    public static function buildGetQuery(array|string $columns = ['*'], array $filtersColumns = []): string
    {
        $columns = implode(', ', $columns);
        $query = ("SELECT $columns FROM " . Model::getTableName());

        if (!empty($filtersColumns)) {
            if (count($filtersColumns) > 1) {
                $filtersColumns = (implode(' = ? AND ', $filtersColumns) . ' = ?');
            } else {
                // 1
                $filtersColumns = $filtersColumns[0] . ' = ?';
            }
            $query .= (' WHERE ' . $filtersColumns);
        }

        return $query;
    }

    public static function buildUpdateQuery(array $columns): string
    {
        $placeholders = '';
        foreach ($columns as $column) {
            $placeholders .= "$column = :$column, ";
        }
        $placeholders = rtrim($placeholders, ', ');

        return ('UPDATE ' . Model::getTableName() . " SET $placeholders WHERE id = :id");
    }

    public static function buildDeleteQuery(): string
    {
        return ('DELETE FROM ' . Model::getTableName() . " WHERE id = ?");
    }
}
