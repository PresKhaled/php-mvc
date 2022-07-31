<?php

namespace App\controllers;

use Khaled\PhpMvc\http\Connection;

class RegisterController
{
    public function index(Connection $connection): void
    {
        echo 'register|' . $connection->method();
    }
}
