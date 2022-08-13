<?php

namespace Tests\unit\validation\rules;

use App\validation\Validator;
use Minwork\Helper\Arr;
use Tests\CustomTestCase;

class ConfirmedRuleTest extends CustomTestCase
{
    /** @test */
    public function it_succeeds_when_the_field_value_matches_the_field_assertion_value()
    {
        $data = [
            'password' => '12345_',
            'password_confirmation' => '12345_',
        ];
        $validator = new Validator;
        $validated = $validator->make([
            'password' => 'required|confirmed'
        ], $data);

        $this->assertEquals($data['password'], $data['password_confirmation']);
        $this->assertFalse($validator->hasErrors());
        $this->assertEquals($data['password'], $validated['password']);
    }

    /** @test */
    public function it_fails_when_the_field_value_does_not_matches_the_field_assertion_value()
    {
        $data = [
            'password' => '12345_',
            'password_confirmation' => '12345',
        ];
        $messages = ['password' => 'The password and password confirmation fields values do not match.'];
        $validator = new Validator;
        $validator->make([
            'password' => 'required|confirmed'
        ], $data, $messages);

        $this->assertNotEquals($data['password'], $data['password_confirmation']);
        $this->assertTrue($validator->hasErrors());
        $this->assertEquals($messages, Arr::flattenSingle($validator->errors));
    }
}
