<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\PassValidator;
use Substantiation\FailValidator;
use function Substantiation\Shorthand\pass;
use function Substantiation\Shorthand\fail;

class TrivialValidatorTest extends TestCase {
    public function testPassValidator() {
        $validator = new PassValidator();
        $result = $validator->validate($this->faker->randomNumber());
        $this->assertSome($result);
    }

    public function testFailValidator() {
        $validator = new FailValidator();
        $result = $validator->validate($this->faker->randomNumber());
        $this->assertNone($result);
    }

    public function testPassValidatorShorthand() {
        $validator = pass();
        $result = pass()->validate($this->faker->randomNumber());
        $this->assertSome($result);
    }

    public function testFailValidatorShorthand() {
        $result = fail()->validate($this->faker->randomNumber());
        $this->assertNone($result);
    }
}
