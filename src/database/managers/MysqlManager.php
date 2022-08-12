<?php

namespace Khaled\PhpMvc\database\managers;

use App\contracts\DatabaseManager;
use App\models\Model;
use Exception;
use Khaled\PhpMvc\database\grammars\MysqlGrammar;
use Khaled\PhpMvc\support\WithArrayAccess;
use Minwork\Helper\Arr;
use PDO;
use Throwable;

class MysqlManager implements DatabaseManager
{
    protected static PDO $instance;

    /**
     * -
     *
     * @return PDO
     */
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
     * -
     *
     * @param string $query
     * @param array $values
     * @return WithArrayAccess
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

    /**
     * -
     *
     * @param array $data
     * @return object|bool
     */
    public function create(array $data): object|bool
    {
        $query = MysqlGrammar::buildCreateQuery(array_keys($data));
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

    /**
     * -
     *
     * @param array|string $columns
     * @param array $filters
     * @return array
     */
    public function get(array|string $columns = ['*'], array $filters = []): array
    {
        if (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $query = MysqlGrammar::buildGetQuery($columns, array_keys($filters));
        $statement = self::$instance->prepare($query);

        if (!empty($filters)) {
            foreach (array_values($filters) as $index => $filterColumn) {
                $statement->bindValue(($index + 1), $filterColumn);
            }
        }

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, Model::getModel());
    }

    /**
     * -
     *
     * @param int $rowId
     * @param array $data
     * @return bool
     */
    public function update(int $rowId, array $data): bool
    {
        $query = MysqlGrammar::buildUpdateQuery(array_keys($data));
        $statement = self::$instance->prepare($query);

        Arr::each(
            $data,
            fn($column, $value) => $statement->bindParam(":$column", $value),
            Arr::EACH_KEY_VALUE,
        );

        $statement->bindParam(':id', $rowId);

        return $statement->execute();
    }

    /**
     * -
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = MysqlGrammar::buildDeleteQuery();
        $statement = self::$instance->prepare($query);
        $statement->bindValue(1, $id);

        return $statement->execute();
    }
}
