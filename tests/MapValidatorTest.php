<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\MapValidator;
use Substantiation\RequiredPair;
use Substantiation\OptionalPair;
use function Substantiation\Shorthand\pass;
use function Substantiation\Shorthand\fail;
use function Substantiation\Shorthand\required;
use function Substantiation\Shorthand\optional;

class MapValidatorTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
        $this->key = $this->faker->unique()->words();
        $this->value = $this->faker->words();
    }

    public function testValidMapValidation() {
        $validator = new MapValidator(
            new RequiredPair($this->key[0], pass()),
            new OptionalPair($this->key[1], fail()),
            new RequiredPair($this->key[2], pass())
        );
        $result = $validator->validate([
            $this->key[0] => $this->value[0],
            $this->key[2] => $this->value[2]
        ]);
        $this->assertSome($result);
    }

    public function testMissingRequiredKeys() {
        $validator = new MapValidator(
            new RequiredPair($this->key[0], pass())
        );
        $result = $validator->validate([]);
        $this->assertNone($result);
    }

    public function testTooManyKeys() {
        $validator = new MapValidator();
        $result = $validator->validate([
            $this->key[1] => $this->value[1],
            $this->key[2] => $this->value[2]
        ]);
        $this->assertNone($result);
    }

    public function testFailValidation() {
        $validator = new MapValidator(
            required($this->key[1], fail())
        );
        $result = $validator->validate([
            $this->key[1] => $this->value[1],
        ]);
        $this->assertNone($result);
    }

    public function testFailOptionalValidation() {
        $validator = new MapValidator(
            optional($this->key[1], fail()),
            required($this->key[2], pass())
        );
        $result = $validator->validate([
            $this->key[1] => $this->value[1],
            $this->key[2] => $this->value[2],
        ]);
        $this->assertNone($result);
    }
}
