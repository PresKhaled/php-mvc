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
     * -
     *
     * @throws Exception
     */
    #[NoReturn] public function create(): never
    {
        view('auth.register');
    }

    /**
     * -
     *
     * @param Connection $connection
     * @return void
     */
    #[NoReturn] public function store(Connection $connection): void
    {
        $all = $connection->all();
        $validator = new Validator;
        $validated = $validator->make([
            'name' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ], $all);

        if ($validator->hasErrors()) {
            // Flash the old values for the applicable fields.
            Arr::each($all, function (string $field, mixed $value) {
                if (!in_array($field, OLD_VALUES_NEVER_FLUSH)) {
                    app()->session->setFlash($field, $value, OLD_VALUES_KEY);
                }
            }, Arr::EACH_KEY_VALUE);

            foreach ($validator->errors as $field => $messages) {
                app()->session->setFlash($field, $messages);
            }

            back();
        }

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        app()->session->setFlash('registered', "Welcome $user->name");

        back();
    }
}
