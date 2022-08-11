<?php

namespace App\controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class MainController
{
    /**
     * -
     *
     * @throws Exception
     */
    #[NoReturn] public function show(): never
    {
        view('homepage');
    }
}
