<?php

namespace Tests\unit;

use App\validation\Validator;
use Minwork\Helper\Arr;
use Tests\CustomTestCase;

class RequiredRuleTest extends CustomTestCase
{
    /** @test */
    public function ensures_that_the_field_exists_and_has_value()
    {
        $data = [
            'name' => 'Khaled Mohsen',
        ];
        $messages = [
            'email' => 'The email field is mandatory.',
            'password' => 'The email field is mandatory.',
        ];
        $validator = new Validator;
        $validator->make([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ], $data, $messages);

        $this->assertTrue($validator->hasErrors());
        $this->assertEquals($messages, Arr::flattenSingle($validator->errors));
    }
}
