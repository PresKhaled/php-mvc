<?php

namespace App;

use App\contracts\DatabaseManager;
use Exception;
use Khaled\PhpMvc\database\DB;
use Khaled\PhpMvc\database\managers\MysqlManager;
use Khaled\PhpMvc\http\Connection;
use Khaled\PhpMvc\http\Response;
use Khaled\PhpMvc\http\Route;

class Application
{
    protected readonly Route $route;
    public readonly DB $database;

    public function __construct(
        public readonly Connection $connection = new Connection,
        public readonly Response $response = new Response,
        public readonly Session $session = new Session,
    ) {
        $this->route = new Route($this->connection, $this->response);
        $this->database = new DB($this->getDatabaseEngine());
    }

    /**
     * Run the application.
     *
     * @throws Exception
     */
    public function run(): void
    {
        $this->database->init();
        $this->route->resolve();
    }

    /**
     * -
     *
     * @return DatabaseManager
     */
    private function getDatabaseEngine(): DatabaseManager
    {
        $engine = env('DB_ENGINE', 'mysql');

        return match ($engine) {
            'mysql' => new MysqlManager,
            default => new MysqlManager,
        };
    }
}
