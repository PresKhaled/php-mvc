<?php

namespace App\controllers;

use App\models\User;
use App\validation\Validator;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Khaled\PhpMvc\http\Connection;
use Minwork\Helper\Arr;

class RegisterController
{
    /**
     * @throws Exception
     */
    #[NoReturn] public function create(Connection $connection): void
    {
        view('register');
    }

    public function store(Connection $connection)
    {
        $validator = new Validator;
        $validated = $validator->make([
            'name' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ], $connection->all());

        if ($validator->hasErrors()) {
            // dump($validator->errors);
            app()->session->flash('old', "Welcome {$user->name}");
            foreach ($validator->errors as $field => $messages) {
                // dump($field, $messages);
                app()->session->flash($field, $messages);
            }

            // dump($_SESSION);

            back();
        }

        $user = User::create($validated);

        app()->session->flash('registered', "Welcome {$user->name}");

        back();
    }
}
