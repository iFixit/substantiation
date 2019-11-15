<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\MapValidator;
use Substantiation\RequiredPair;
use Substantiation\OptionalPair;
use Substantiation\InvalidValidatorException;
use Substantiation\ValidationFailure;
use function Substantiation\Shorthand\pass;
use function Substantiation\Shorthand\fail;
use function Substantiation\Shorthand\required;
use function Substantiation\Shorthand\optional;

class MapValidatorTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
        $this->keys = $this->faker->unique()->words();
        $this->values = $this->faker->words();
        $this->key = $this->keys[0];
    }

    public function testValidMapValidation() {
        $validator = new MapValidator(
            new RequiredPair($this->keys[0], pass()),
            new OptionalPair($this->keys[1], fail()),
            new RequiredPair($this->keys[2], pass())
        );
        $result = $validator->validate([
            $this->keys[0] => $this->values[0],
            $this->keys[2] => $this->values[2]
        ]);
        $this->assertSome($result);
    }

    public function testMissingRequiredKeys() {
        $validator = new MapValidator(
            new RequiredPair($this->keys[0], pass())
        );
        $result = $validator->validate([]);
        $this->assertNone($result);
    }

    public function testTooManyKeys() {
        $validator = new MapValidator();
        $result = $validator->validate([
            $this->keys[1] => $this->values[1],
            $this->keys[2] => $this->values[2]
        ]);
        $this->assertNone($result);
    }

    public function testFailValidation() {
        $validator = new MapValidator(
            required($this->keys[1], fail())
        );
        $result = $validator->validate([
            $this->keys[1] => $this->values[1],
        ]);
        $this->assertNone($result);
    }

    public function testFailOptionalValidation() {
        $validator = new MapValidator(
            optional($this->keys[1], fail()),
            required($this->keys[2], pass())
        );
        $result = $validator->validate([
            $this->keys[1] => $this->values[1],
            $this->keys[2] => $this->values[2],
        ]);
        $this->assertNone($result);
    }

    public function testNonMapValidation() {
        $validator = new MapValidator(
            optional($this->keys[1], fail()),
            required($this->keys[2], pass())
        );
        $result = $validator->validate($this->faker->randomNumber());
        $this->assertNone($result);
    }

    public function testNoDuplicateKeys1() {
        $this->expectException(InvalidValidatorException::class);
        new MapValidator(
            required($this->key, pass()),
            required($this->key, pass())
        );
    }

    public function testNoDuplicateKeys2() {
        $this->expectException(InvalidValidatorException::class);
        new MapValidator(
            required($this->key, pass()),
            optional($this->key, pass())
        );
    }

    public function testMultipleFailures() {
        $validator = new MapValidator(
         new RequiredPair('abc', pass()),
         new OptionalPair('def', fail())
        );
        $result = $validator->validate(['def' => 0]);
        $this->assertOnNone(
         function($f) {
             $this->assertEquals([
                 'abc' => new ValidationFailure("Key abc not present"),
                 'def' => new ValidationFailure("Forced failure")
             ], $f);
         },
         $result
        );
    }
}
