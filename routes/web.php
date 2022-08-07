<?php
use App\controllers\InvokableController;
use App\controllers\MainController;
use App\controllers\PostController;
use App\controllers\RegisterController;
use Khaled\PhpMvc\http\Connection;
use Khaled\PhpMvc\http\Route;

Route::get('/', [MainController::class, 'show']);
Route::get('/invoke', InvokableController::class);
Route::get('posts', [PostController::class, 'index']);
Route::get('register', [RegisterController::class, 'create']);
Route::get('/login', function (Connection $connection) {
    echo 'login|' . $connection->method();
});

// Errors
Route::get('/404', fn() => view('errors.404'));
Route::get('/500', fn() => view('errors.500'));
