<?php

namespace Tests;

use Dotenv\Dotenv;
use Exception;
use NunoMaduro\Collision\Provider;
use PHPUnit\Framework\TestCase;

class CustomTestCase extends TestCase
{
    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        Dotenv::createImmutable(base_path())->safeLoad();

        app()->database->init();

        (new Provider)->register();
    }
}
