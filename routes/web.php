<?php

use App\controllers\MainController;
use App\controllers\PostController;
use App\controllers\RegisterController;
use Khaled\PhpMvc\http\Connection;
use Khaled\PhpMvc\http\Route;

Route::get('main', [MainController::class, 'show']);
Route::get('posts', [PostController::class, 'index']);
Route::get('register', [RegisterController::class, 'create']);
Route::get('/login', function (Connection $connection) {
    echo 'login|' . $connection->method();
});
