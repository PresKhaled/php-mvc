<?php

namespace App\controllers;

use Khaled\PhpMvc\http\Connection;

class RegisterController
{
    public function create(Connection $connection)
    {
        return view('register');
    }
}
