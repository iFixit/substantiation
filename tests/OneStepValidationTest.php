<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use function Substantiation\Shorthand\valid;
use function Substantiation\Shorthand\validate;

class OneStepValidationTest extends TestCase {
    public function testPredicateValidation() {
        $this->assertTrue(valid([], []));
        $this->assertTrue(valid('is_int', 42));
        $this->assertFalse(valid('is_string', 42));
    }

    public function testImmediateValidation() {
        $this->assertSome(validate([], []));
        $this->assertSome(validate('is_int', 42));
        $this->assertNone(validate('is_string', 42));
    }
}
