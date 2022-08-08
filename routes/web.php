<?php
use App\controllers\InvokableController;
use App\controllers\MainController;
use App\controllers\PostController;
use App\controllers\RegisterController;
use Khaled\PhpMvc\http\Connection;
use Khaled\PhpMvc\http\Route;

Route::get('/', [MainController::class, 'show']);
Route::get('/invoke', InvokableController::class);
//Route::get('/', function () {
//    /*app()->session->flash('validation_errors', [
//        'name' => 'Name is mandatory.',
//        'email' => 'Invalid E-Mail.',
//    ]);*/
//
//    /*dump('Has');
//    dump(app()->session->has('validation_errors', true));
//    dump('Get');
//    dump(app()->session->get('validation_errors', true));
//    app()->session->remove('validation_errors', true);
//    dump('Has');
//    dump(app()->session->has('validation_errors', true));
//    dump('Get');
//    dump(app()->session->get('validation_errors', true));*/
//
//    /*app()->session->set('set_key', 'set_value');
//    dump('Has');
//    dump(app()->session->has('set_key'));
//    dump('Get');
//    dump(app()->session->get('set_key'));
//    app()->session->remove('set_key');
//    dump('Has');
//    dump(app()->session->has('set_key'));
//    dump('Get');
//    dump(app()->session->get('set_key'));*/
//    dump($_SESSION);
//});
Route::get('posts', [PostController::class, 'index']);
Route::get('register', [RegisterController::class, 'create']);
Route::post('register', [RegisterController::class, 'store']);
Route::get('/login', function (Connection $connection) {
    echo 'login|' . $connection->method();
});

// Errors
Route::get('/404', fn() => view('errors.404'));
Route::get('/500', fn() => view('errors.500'));
