<?php

namespace Khaled\PhpMvc\http;

use Exception;

class Route
{
    public Connection $connection;
    public Response $response;
    public static array $routes = [];

    /**
     * @param Connection $connection
     * @param Response $response
     */
    public function __construct(Connection $connection, Response $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    /**
     *
     *
     * @param string $uri
     * @param callable|array $action
     * @return void
     */
    public static function get(string $uri, callable|array $action): void {
        $uri = self::turnOnSlash($uri);

         self::$routes['get'][$uri] = $action;
    }

    /**
     *
     *
     * @param string $uri
     * @param callable|array $action
     * @return void
     */
    public static function post(string $uri, callable|array $action): void {
        $uri = self::turnOnSlash($uri);

        self::$routes['post'][$uri] = $action;
    }

    /**
     *
     *
     * @throws Exception
     */
    public function resolve() {
        $connection = $this->connection;
        $method = $connection->method();
        $uri = $connection->uri();
        $action = (self::$routes[$method][$uri]) ?? false;

        // Closure
        if (is_callable($action)) {
            return call_user_func_array($action, [$connection]);
        }

        // Controller
        if (is_array($action)) {
            // These variables prevent [is_callable] from modifying the [$action] reference.
            $class = $action[0];
            $method = $action[1];

            if (!is_callable($class, true, $method)) {
                throw new Exception('Invalid controller or method not found.');
            }

            return call_user_func_array([new $action[0], $action[1]], [$connection]);
        }
    }

    /**
     * Add a forward slash at the beginning of the URI if it is not included.
     *
     * @param string $uri
     * @return string
     */
    protected static function turnOnSlash(string $uri): string
    {
        if (str_starts_with($uri, '/')) {
            return $uri;
        }

        return ('/' . $uri);
    }
}
