<?php

namespace App;

abstract class Model
{
    protected static string $instance;

    public static function rawQuery(string $query, array $values = []): WithArrayAccess
    {
        self::$instance = static::class;

        return app()->database->rawQuery($query, $values);
    }

    public static function create(array $data): object|bool
    {
        self::$instance = static::class;

        return app()->database->create($data);
    }

    public static function update(int $rowId, array $data): bool
    {
        self::$instance = static::class;

        return app()->database->update($rowId, $data);
    }

    public static function all(array|string $columns = ['*']): array
    {
        self::$instance = static::class;

        return app()->database->get($columns);
    }

    public static function where(array|string $columns = ['*'], array $filters = []): array
    {
        self::$instance = static::class;

        return app()->database->get($columns, $filters);
    }

    public static function delete(int $id): bool
    {
        self::$instance = static::class;

        return app()->database->delete($id);
    }

    public static function getModel(): string {
        return self::$instance;
    }

    public static function getTableName(): string
    {
        $name = explode('\\', self::$instance);

        return strtolower(end($name) . 's');
    }
}
