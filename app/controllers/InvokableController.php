<?php

namespace App\controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class InvokableController
{
    /**
     * -
     *
     * @throws Exception
     */
    #[NoReturn] public function __invoke(): never
    {
        view('misc.invoked');
    }
}
