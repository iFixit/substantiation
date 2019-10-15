<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\OptionalPair;
use Optional\Option;
use function Substantiation\Shorthand\pass;
use function Substantiation\Shorthand\fail;
use function Substantiation\Shorthand\optional;

class OptionalPairTest extends TestCase {
    public function setUp(): void {
        parent::setUp();
        $this->value = Option::some($this->faker->randomNumber());
    }

    public function testPassthroughPassValidator() {
        $key = $this->faker->word;
        $validator = new OptionalPair($key, pass());
        $result = $validator->validate($this->value);
        $this->assertSome($result);
    }

    public function testPassthroughFailValidator() {
        $key = $this->faker->word;
        $validator = new OptionalPair($key, fail());
        $result = $validator->validate($this->value);
        $this->assertNone($result);
    }

    public function testMissingKey() {
        $key = $this->faker->word;
        $validator = new OptionalPair($key, fail());
        $result = $validator->validate(Option::none());
        $this->assertSome($result);
    }

    public function testShorthandPassthroughPassValidator() {
        $key = $this->faker->word;
        $validator = optional($key, pass());
        $result = $validator->validate($this->value);
        $this->assertSome($result);
    }

    public function testShorthandPassthroughFailValidator() {
        $key = $this->faker->word;
        $validator = optional($key, fail());
        $result = $validator->validate($this->value);
        $this->assertNone($result);
    }
}
