<?php

namespace Khaled\PhpMvc\http;

class Route
{
    public Connection $connection;
    public Response $response;
    public static array $routes = [];

    public function __construct(Connection $connection, Response $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public static function get(string $uri, callable|string $action): void {
         self::$routes['get'][$uri] = $action;
    }

    public static function post(string $uri, string $action): void {
        self::$routes['post'][$uri] = $action;
    }
}
