<?php

namespace App\models;

use Khaled\PhpMvc\support\WithArrayAccess;

abstract class Model
{
    protected static string $instance;

    /**
     * -
     *
     * @param string $query
     * @param array $values
     * @return WithArrayAccess
     */
    public static function rawQuery(string $query, array $values = []): WithArrayAccess
    {
        self::$instance = static::class;

        return app()->database->rawQuery($query, $values);
    }

    /**
     * -
     *
     * @param array $data
     * @return object|bool
     */
    public static function create(array $data): object|bool
    {
        self::$instance = static::class;

        return app()->database->create($data);
    }

    /**
     * -
     *
     * @param int $rowId
     * @param array $data
     * @return bool
     */
    public static function update(int $rowId, array $data): bool
    {
        self::$instance = static::class;

        return app()->database->update($rowId, $data);
    }

    /**
     * -
     *
     * @param array|string $columns
     * @return array
     */
    public static function all(array|string $columns = ['*']): array
    {
        self::$instance = static::class;

        return app()->database->get($columns);
    }

    /**
     * -
     *
     * @param array|string $columns
     * @param array $filters
     * @return array
     */
    public static function where(array|string $columns = ['*'], array $filters = []): array
    {
        self::$instance = static::class;

        return app()->database->get($columns, $filters);
    }

    /**
     * -
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        self::$instance = static::class;

        return app()->database->delete($id);
    }

    /**
     * -
     *
     * @return string
     */
    public static function getModel(): string
    {
        return self::$instance;
    }

    /**
     * -
     *
     * @return string
     */
    public static function getTableName(): string
    {
        $name = explode('\\', self::$instance);

        return strtolower(end($name) . 's');
    }
}
