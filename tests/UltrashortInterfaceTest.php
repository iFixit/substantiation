<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Substantiation\Validator;
use Substantiation\InvalidValidatorException;
use function Substantiation\Shorthand\validator;
use function Substantiation\Shorthand\optional;
use function Substantiation\Shorthand\required;
use function Substantiation\Shorthand\call;
use function Substantiation\Shorthand\pass;
use function Substantiation\Shorthand\fail;

class UltrashortInterfaceTest extends TestCase {
    public function testUltrashortInterface() {
        $this->assertValid(validator('is_int'), 4);
        $this->assertInvalid(validator('is_int'), []);
        $this->assertValid(validator(pass()), []);
        $this->assertValid(validator([fail()]), []);
        $this->assertInvalid(validator([fail()]), [1]);
        $this->assertInvalid(validator([fail()]), 42);
        $this->assertValid(validator([pass()]), [1]);

        $key = $this->faker->numberBetween();
        $value = $this->faker->word;
        $this->assertValid(validator([$key => pass()]), [$key => $value]);

        $key2 = $this->faker->numberBetween();
        $key2 = "fish";
        $this->assertValid(validator([
            $key => pass(),
            optional($key2, fail())
        ]), [$key => $value]);
    }

    public function testFailOnInvalidArrayEntry() {
        $this->expectException(InvalidValidatorException::class);
        var_dump(validator([1 => "is_int", pass()])->validate(34));
    }

    public function testComplexSequentiallyIndexedArray() {
        $this->assertValid(validator([
            optional('abc', fail()),
            optional('def', fail()),
            required('q', call('is_int')),
            required('v', validator('is_string')),
            optional('t', pass()),
            23 => 'is_int',
            'fish' => 'is_callable',
        ]), [
            'q' => 42,
            'v' => "thing",
            't' => 123,
            23 => 23,
            'fish' => function() {},
        ]);
    }

    public function testMultiValueArray() {
        $this->assertValid(validator([
            pass(),
            pass(),
            'is_int'
        ]), [
            'fish',
            function() {},
            42
        ]);
    }

    private function assertValid(Validator $validator, $data) {
        $this->assertSome($validator->validate($data));
    }

    private function assertInvalid(Validator $validator, $data) {
        $this->assertNone($validator->validate($data));
    }
}
