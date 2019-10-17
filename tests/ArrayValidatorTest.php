<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\ArrayValidator;
use Substantiation\RequiredPair;
use Substantiation\OptionalPair;
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
}
