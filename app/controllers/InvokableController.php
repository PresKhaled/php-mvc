<?php

namespace App\controllers;

use Exception;

class InvokableController
{
    /**
     * @throws Exception
     */
    public function __invoke(): bool|string
    {
        return view('invoked');
    }
}
