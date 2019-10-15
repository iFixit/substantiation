<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\CallableValidator;

class CallableValidatorTest extends TestCase
{
    public function testValidCallableValidation() {
        $validator = new CallableValidator('is_int');
        $result = $validator->validate($this->faker->randomNumber());
        $this->assertSome($result);
    }

    public function testInvalidCallableValidation() {
        $validator = new CallableValidator('is_int');
        $result = $validator->validate($this->faker->word);
        $this->assertNone($result);
    }
}
