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
    protected Connection $connection;
    protected Response $response;
    public Session $session;
    protected Route $route;
    public DB $database;

    public function __construct()
    {
        $this->connection = new Connection;
        $this->response = new Response;
        $this->session = new Session;
        $this->route = new Route($this->connection, $this->response);
        $this->database = new DB($this->getDatabaseEngine());
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->route->resolve();
        $this->database->init();
    }

    private function getDatabaseEngine(): DatabaseManager
    {
        $engine = env('DB_ENGINE', 'mysql');

        return match ($engine) {
            'mysql' => new MysqlManager,
            default => new MysqlManager,
        };
    }
}
