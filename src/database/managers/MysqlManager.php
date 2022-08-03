<?php

namespace Khaled\PhpMvc\database\managers;

use App\contracts\DatabaseManager;
use App\Model;
use App\WithArrayAccess;
use Exception;
use Khaled\PhpMvc\database\grammers\MysqlGrammer;
use Minwork\Helper\Arr;
use PDO;
use Throwable;

class MysqlManager implements DatabaseManager
{
    protected static PDO $instance;

    public function connect(): PDO
    {
        $database = env('DB_ENGINE');
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $name = env('DB_NAME');
        $charset = env('DB_CHARSET');
        $dataSourceName = ("$database:" . "host=$host;" . "port=$port;" . "dbname=$name;" . "charset=$charset;"); // https://www.php.net/manual/en/ref.pdo-mysql.connection.php

        if (!isset(self::$instance)) {
            self::$instance = new PDO($dataSourceName, env('DB_USERNAME'), env('DB_PASSWORD'));
        }

        return self::$instance;
    }

    /**
     * @throws Exception
     */
    public function rawQuery(string $query, array $values = []): WithArrayAccess
    {
        self::$instance->beginTransaction();

        try {
            $statement = self::$instance->prepare($query);

            foreach ($values as $index => $value) {
                $statement->bindValue(($index + 1), $value);
            }

            self::$instance->commit();

            $statement->execute();

            return with_array_access($statement->fetchAll());
        } catch (Throwable) {
            self::$instance->rollBack();

            throw new Exception;
        }
    }

    public function create(array $data): object|bool
    {
        $query = MysqlGrammer::buildCreateQuery(array_keys($data));
        $statement = self::$instance->prepare($query);

        foreach (array_values($data) as $index => $value) {
            $statement->bindValue(($index + 1), $value);
        }

        $status = $statement->execute();

        if ($status) {
            $user = $this->get(filters: ['id' => self::$instance->lastInsertId()]);

            return $user[0];
        }

        return false;
    }

    public function get(array|string $columns = ['*'], array $filters = []): array
    {
        if (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $query = MysqlGrammer::buildGetQuery($columns, array_keys($filters));
        dump($query);
        $statement = self::$instance->prepare($query);

        if (!empty($filters)) {
            foreach (array_values($filters) as $index => $filterColumn) {
                dump($filterColumn);
                $statement->bindValue(($index + 1), $filterColumn);
            }
        }

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, Model::getModel());
    }

    public function update(int $rowId, array $data): bool
    {
        $query = MysqlGrammer::buildUpdateQuery(array_keys($data));
        $statement = self::$instance->prepare($query);

        Arr::each(
            $data,
            fn($column, $value) => $statement->bindParam(":$column", $value),
            Arr::EACH_KEY_VALUE,
        );

        $statement->bindParam(':id', $rowId);

        return $statement->execute();
    }

    public function delete(int $id): bool
    {
        $query = MysqlGrammer::buildDeleteQuery();
        $statement = self::$instance->prepare($query);
        $statement->bindValue(1, $id);

        return $statement->execute();
    }
}
