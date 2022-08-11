<?php

namespace Tests\unit;

use App\models\User;
use App\validation\Validator;
use Tests\CustomTestCase;

class UserTest extends CustomTestCase
{
    /** @test */
    public function can_create_a_new_account(): void
    {
        $data = [
            'name' => 'Khaled Mohsen',
            'email' => 'pres.kbayomy@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $validator = new Validator;

        $validated = $validator->make([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ], $data);

        $this->assertFalse($validator->hasErrors(), 'Validation errors.');

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        $this->assertInstanceOf(User::class, $user, 'Not registered.');

        $welcomeFlashMessage = "Welcome $user->name";

        app()->session->setFlash('registered', $welcomeFlashMessage);

        $this->assertEquals($welcomeFlashMessage, $_SESSION[FLASH_MESSAGES_KEY]['registered']['content']);
    }
}
