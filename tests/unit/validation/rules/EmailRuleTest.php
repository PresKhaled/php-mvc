<?php

namespace Tests\unit\validation\rules;

use App\validation\Validator;
use Minwork\Helper\Arr;
use Tests\CustomTestCase;

class EmailRuleTest extends CustomTestCase
{
    /** @test */
    public function it_succeeds_when_the_field_value_structure_is_valid()
    {
        $validator = new Validator;
        $validator->make([
            'email' => 'email'
        ], [
            'email' => ($email = 'valid@example.com')
        ]);

        $this->assertEquals($email, filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    /** @test */
    public function it_fails_when_the_field_value_structure_is_invalid()
    {
        $email = ['email' => 'invalid@example'];
        $messages = ['email' => 'Invalid E-Mail.'];
        $validator = new Validator;
        $validator->make([
            'email' => 'email'
        ], $email, $messages);

        $this->assertFalse(filter_var($email['email'], FILTER_VALIDATE_EMAIL));
        $this->assertTrue($validator->hasErrors());
        $this->assertEquals($messages, Arr::flattenSingle($validator->errors));
    }
}
