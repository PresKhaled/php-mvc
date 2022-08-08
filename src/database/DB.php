<?php

namespace Khaled\PhpMvc\database;

use App\contracts\DatabaseManager;
use App\models\Model;
use Exception;
use Khaled\PhpMvc\support\WithArrayAccess;

class DB
{
    protected DatabaseManager $manager;

    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * -
     *
     * @return void
     */
    public function init(): void {
        $this->manager->connect();
    }

    /**
     * -
     *
     * @param string $query
     * @param array $data
     * @return WithArrayAccess
     */
    protected function rawQuery(string $query, array $data = []): WithArrayAccess
    {
        return $this->manager->rawQuery($query, $data);
    }

    /**
     * -
     *
     * @param array $data
     * @return object|bool
     */
    protected function create(array $data): object|bool
    {
        return $this->manager->create($data);
    }

    /**
     * -
     *
     * @param int|Model $rowId
     * @param array $data
     * @return bool
     */
    protected function update(int|Model $rowId, array $data): bool
    {
        return $this->manager->update($rowId, $data);
    }

    /**
     * -
     *
     * @param array|string $columns
     * @param array $filters
     * @return array
     */
    protected function get(array|string $columns = ['*'], array $filters = []): array
    {
        return $this->manager->get($columns, $filters);
    }

    /**
     * -
     *
     * @param int $id
     * @return bool
     */
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
