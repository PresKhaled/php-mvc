<?php

namespace Tests\unit\validation;

use App\validation\Validator;
use Minwork\Helper\Arr;
use Tests\CustomTestCase;

class ValidatorTest extends CustomTestCase
{
    protected static Validator $validator;
    protected static array $data;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$data = [
            'name' => 'Khaled Mohsen',
            'email' => 'pres.kbayomy@gmail.com',
            'password' => '_12345',
            'password_confirmation' => '_12345',
        ];

        self::$validator = new Validator;
    }

    /** @test */
    public function must_validate_the_specified_data()
    {
        $data = self::$data;
        // [Validator] can provide access to the value of a field in another field, (like here) the "password" field will have access to the value of the "password_confirmation" field.
        $validated = self::$validator->make([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|between:5,8|confirmed',
        ], $data);

        unset($data['password_confirmation']);

        $this->assertFalse(self::$validator->hasErrors());
        $this->assertEquals($data, $validated);
    }

    /** @test */
    public function can_accept_custom_error_messages_for_fields()
    {
        $data = self::$data;
        $data['email'] = 'invalid@example';
        unset($data['password_confirmation']);

        $customMessages = [
            'email' => 'The specified E-Mail is invalid.',
            'password' => 'The password and password confirmation must be identical.',
        ];

        self::$validator->make([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|between:5,8|confirmed',
        ], $data, messages: $customMessages);

        $this->assertTrue(self::$validator->hasErrors());

        // Flat the array if there's one error only (like here) because the errors array values are arrays that can contain multiple error messages.
        $this->assertEquals($customMessages, Arr::flattenSingle(self::$validator->errors));
    }
}
