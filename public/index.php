<?php

use Khaled\PhpMvc\http\Route;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/web.php';

dump(Route::$routes);
