<?php

use App\Hash;
use App\validation\Validator;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require_once 'app/helpers.php';
require_once base_path() . '/vendor/autoload.php';
require_once base_path() . '/routes/web.php';

app()->run();

/*$databaseConfig = config('database');
$key = 'port.nested.level';

dump(
    $databaseConfig->exists($key),
    $databaseConfig->get($key),
    $databaseConfig->set($key, 5000),
    $databaseConfig->get($key),
    $databaseConfig->unset($key),
    $databaseConfig->get($key),
    config('database.host'),
);*/

// dump(Hash::passwordVerify('12345', Hash::password('12345')));

/*$validator = new Validator;
$validator->make([
    'name' => 'required',
    'email' => 'required',
    'password' => 'required',
], [
    'name' => 'Name',
]);*/

/*$validator2 = new Validator;
$validator2->make([
        'name' => ['required'],
        'email' => 'required|email',
        'password' => ['required', 'between:3,5', 'confirmed'],
    ], [
        'name' => 'Name',
        'email' => 'email@example.',
        'password' => '035',
        'password_confirmation' => '035',
    ],
    attaches: [
        'name' => 'email',
    ],
);*/

/*if ($validator->hasErrors()) {
    dump($validator);
}*/

/*if ($validator2->hasErrors()) {
    dump($validator2);
}*/

