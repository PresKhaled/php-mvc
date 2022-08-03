<?php

namespace Khaled\PhpMvc\database;

use App\contracts\DatabaseManager;
use App\Model;
use App\WithArrayAccess;
use Exception;

class DB
{
    protected DatabaseManager $manager;

    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }

    public function init(): void {
        $this->manager->connect();
    }

    protected function rawQuery(string $query, array $data = []): WithArrayAccess
    {
        return $this->manager->rawQuery($query, $data);
    }

    protected function create(array $data): object|bool
    {
        return $this->manager->create($data);
    }

    protected function update(int|Model $rowId, array $data): bool
    {
        return $this->manager->update($rowId, $data);
    }

    protected function get(array|string $columns = ['*'], array $filters = []): array
    {
        return $this->manager->get($columns, $filters);
    }

    protected function delete(int $id): bool
    {
        return $this->manager->delete($id);
    }

    /**
     * -
     *
     * @throws Exception
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        throw new Exception('The method does not exist.');
    }
}
