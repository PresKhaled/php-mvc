<?php

namespace Tests\unit\validation\rules;

use App\validation\Validator;
use Minwork\Helper\Arr;
use Tests\CustomTestCase;

class BetweenRuleTest extends CustomTestCase
{
    /** @test */
    public function it_succeeds_when_the_field_value_is_between_a_specified_range_of_numbers()
    {
        $values = [24, '_12345_12345_12345_12345'];

        foreach ($values as $value) {
            $data = ['number_of_working_hours_per_day' => $value];
            $min = 1;
            $max = 24;
            $validator = new Validator;
            $validator->make([
                'number_of_working_hours_per_day' => "required|between:$min,$max"
            ], $data);

            $value = is_string($value) ? strlen($value) : $value;

            $this->assertTrue($value >= $min && $value <= $max);
            $this->assertFalse($validator->hasErrors());
        }
    }

    /** @test */
    public function it_fails_when_the_field_value_is_not_between_a_specified_range_of_numbers()
    {
        $values = [25, '_12345_12345_12345_12345_'];

        foreach ($values as $value) {
            $data = ['number_of_working_hours_per_day' => $value];
            $min = 1;
            $max = 24;
            $messages = [
                'number_of_working_hours_per_day' => "The value must be greater than or equal to $min and less than or equal to $max.",
            ];
            $validator = new Validator;
            $validator->make([
                'number_of_working_hours_per_day' => "required|between:$min,$max"
            ], $data, $messages);

            $value = is_string($value) ? strlen($value) : $value;

            $this->assertFalse($value >= $min && $value <= $max);
            $this->assertTrue($validator->hasErrors());
            $this->assertEquals($messages, Arr::flattenSingle($validator->errors));
        }
    }
}
