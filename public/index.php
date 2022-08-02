<?php

use App\Hash;
use App\validation\Validator;

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

$validator = new Validator;
$validator->make([
    'name' => 'required',
    'email' => 'required',
    'password' => 'required',
], [
    'name' => 'Name',
]);

$validator2 = new Validator;
$validator2->make([
    'name' => ['required'],
    'email' => 'required',
    'password' => ['required'],
], [
    'name' => 'Name',
    'email' => 'email@example.com',
    // 'password' => 'password_',
], [
    'password' => 'Custom message.'
]);

if ($validator->hasErrors()) {
    dump($validator);
}

if ($validator2->hasErrors()) {
    dump($validator2);
}

