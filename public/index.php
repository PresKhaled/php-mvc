<?php

require_once 'app/helpers.php';
require_once base_path() . '/vendor/autoload.php';
require_once base_path() . '/routes/web.php';

app()->run();

$databaseConfig = config('database');
$key = 'port.nested.level';

dump(
    $databaseConfig->exists($key),
    $databaseConfig->get($key),
    $databaseConfig->set($key, 5000),
    $databaseConfig->get($key),
    $databaseConfig->unset($key),
    $databaseConfig->get($key),
    config('database.host'),
);
