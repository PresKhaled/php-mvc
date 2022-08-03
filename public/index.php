<?php

use App\Hash;
use App\models\User;
use App\validation\Validator;
use Dotenv\Dotenv;

require_once __DIR__ . '/../app/helpers.php'; // Full path for debugging.
require_once base_path() . '/vendor/autoload.php';
require_once base_path() . '/routes/web.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

app()->run();

/*
 * If the connection is from a browser,
 * another connection will be made to the favicon and if it is not there,
 * another connection will be made to index.php
 * and all code will be executed again.
 */
/*$user = User::create([
    'name' => 'Khaled Mohsen',
    'email' => 'pres.kbayomy@gmail.com',
    'password' => Hash::password('password')
]);*/

// dump($user);

/*$user = User::where(filters: ['id' => 1, 'email' => 'updated_email@gmail.com']);
dump($user);*/

/*$users = User::all();
dump($users);*/

/*$firstUser = User::where(filters: [
    'id' => 1,
]);
dump($firstUser);
$updated = User::update(
    $firstUser[0]->id,
    [
        'email' => 'updated_email@gmail.com',
        'password' => Hash::password('password'),
        'name' => 'Khaled Mohsen',
    ]
);
dump($updated);

$deleted = User::delete(2);
$deleted2 = User::delete(3);

dump($deleted, $deleted2);*/
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

