<?php

namespace App;

use Khaled\PhpMvc\http\Connection;
use Khaled\PhpMvc\http\Response;
use Khaled\PhpMvc\http\Route;

class Application
{
    protected Connection $connection;
    protected Response $response;
    protected Route $route;

    public function __construct()
    {
        $this->connection = new Connection;
        $this->response = new Response;
        $this->route = new Route($this->connection, $this->response);
    }

    public function run() {
        $this->route->resolve();
    }
}
