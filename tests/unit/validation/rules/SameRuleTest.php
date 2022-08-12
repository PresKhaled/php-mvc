<?php

namespace Tests\unit\validation\rules;

use App\validation\Validator;
use Tests\CustomTestCase;

class SameRuleTest extends CustomTestCase
{
    /** @test */
    public function ensure_that_the_field_value_is_the_same_as_the_value_of_another_specified_field()
    {
        $data = [
            'name' => 'Khaled bin Mohsen',
            'username' => 'Khaled bin Mohsen',
        ];
        $validator = new Validator;
        $validated = $validator->make([
            'name' => 'required|same:username',
            'username' => 'required',
        ], $data);

        $this->assertFalse($validator->hasErrors());
        $this->assertEquals($data, $validated);
        $this->assertEquals($data['username'], $data['name']);
    }
}
