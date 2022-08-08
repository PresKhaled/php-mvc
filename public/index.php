<?php

$basePath = __DIR__ . '/../';

require_once $basePath . '/vendor/autoload.php';
require_once $basePath . '/routes/web.php';

$dotenv = Dotenv\Dotenv::createImmutable($basePath);
$dotenv->safeLoad();

/*
 * If the connection is from a browser,
 * another connection will be made to the favicon and if it is not there,
 * another connection will be made to index.php
 * and all code will be executed again.
 */
app()->run();
