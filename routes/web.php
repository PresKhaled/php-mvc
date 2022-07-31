<?php

use App\controllers\RegisterController;
use Khaled\PhpMvc\http\Connection;
use Khaled\PhpMvc\http\Route;

Route::get('register', [RegisterController::class, 'index']);
Route::get('/login', function (Connection $connection) {
    echo 'login|' . $connection->method();
});
