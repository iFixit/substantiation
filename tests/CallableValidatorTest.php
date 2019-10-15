<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\CallableValidator;
use function Substantiation\Shorthand\call;

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

    public function testCallShortcut() {
        $result = call('is_int')->validate($this->faker->randomNumber());
        $this->assertSome($result);
    }
}
