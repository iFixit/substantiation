<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\ArrayValidator;
use Substantiation\RequiredPair;
use Substantiation\OptionalPair;
use Substantiation\ValidationFailure;
use function Substantiation\Shorthand\call;
use function Substantiation\Shorthand\pass;
use function Substantiation\Shorthand\fail;
use function Substantiation\Shorthand\required;
use function Substantiation\Shorthand\optional;

class ArrayValidatorTest extends TestCase
{
    public function testValidArrayValidation() {
        $validator = new ArrayValidator(call('is_string'));
        $result = $validator->validate($this->faker->words());
        $this->assertSome($result);
    }

    public function testInvalidArrayValidation() {
        $validator = new ArrayValidator(call('is_string'));
        $arr = $this->faker->words();
        $arr[] = $this->faker->randomNumber();
        $result = $validator->validate($arr);
        $this->assertNone($result);
    }

    public function testNotArrayValidation() {
        $validator = new ArrayValidator(call('is_string'));
        $result = $validator->validate($this->faker->randomNumber());
        $this->assertNone($result);
    }

    public function testEmptyArrayValidation() {
        $validator = new ArrayValidator(fail());
        $result = $validator->validate([]);
        $this->assertSome($result);
    }

    public function testFailureExplanation() {
        $validator = new ArrayValidator(call('is_int'));
        $result = $validator->validate([0, 0, 'a', 'b', 0]);
        $this->assertOnNone(
         function($f) {
             $this->assertEquals(
              [
               2 => new ValidationFailure("is_int returned false"),
               3 => new ValidationFailure("is_int returned false")
              ], $f);
         }, $result);
    }
}
