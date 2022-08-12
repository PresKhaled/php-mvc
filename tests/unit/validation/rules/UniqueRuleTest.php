<?php

namespace Tests\unit\validation\rules;

use App\models\User;
use App\validation\Validator;
use Tests\CustomTestCase;

class UniqueRuleTest extends CustomTestCase
{
    /** @test */
    public function it_returns_a_validation_error_message_when_the_field_value_already_exists()
    {
        $email = ['email' => 'pres.kbayomy@gmail.com'];

        // Register the E-Mail.
        User::create([
            'name' => 'Khaled Mohsen',
            ...$email,
            'password' => bcrypt('password'),
        ]);

        $validator = new Validator;
        $validator->make(['email' => 'required|email|unique:users,email'], $email);

        $this->assertTrue($validator->hasErrors());
        $this->assertNotNull(($emailMessage = $validator->errors['email']));
        $this->assertEquals('The email is already been taken.', $emailMessage[0]);
    }

    /** @test */
    public function it_succeeds_when_the_field_value_does_not_exist()
    {
        $validator = new Validator;
        $validator->make(['email' => 'required|email|unique:users'], ['email' => 'pres.kbayomy@gmail.com']);

        $this->assertFalse($validator->hasErrors());
        $this->assertEmpty($validator->errors);
    }
}
