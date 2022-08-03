<?php

namespace App\contracts;

use App\Model;
use App\WithArrayAccess;
use PDO;

interface DatabaseManager
{
    public function connect(): PDO;

    public function rawQuery(string $query, array $values = []): WithArrayAccess;

    public function create(array $data): object|bool;

    public function get(array|string $columns = ['*'], array $filters = []): array; // Read

    public function update(int $rowId, array $data): bool;

    public function delete(int $id): bool;
}
