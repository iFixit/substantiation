<?php

declare(strict_types=1);

namespace Substantiation\Tests;
use Substantiation\MapValidator;
use Substantiation\RequiredPair;
use Substantiation\OptionalPair;
use Substantiation\PassValidator;

class PublicPrivateTest extends TestCase {
    private $validator;

    public function setUp(): void {
        parent::setUp();
        // Required parameters
        // - anpan
        // - baba
        // - cesnica
        // Optional parameters
        // - dampfnudel
        // - eggette
        // - farl
        $this->validator = new MapValidator(
            new RequiredPair("anpan", new PassValidator()),
            new RequiredPair("baba", new PassValidator()),
            new RequiredPair("cesnica", new PassValidator()),
            new OptionalPair("dampfnudel", new PassValidator()),
            new OptionalPair("eggette", new PassValidator()),
            new OptionalPair("farl", new PassValidator())
        );
    }

    public function testRequiredParameters() {
        $this->assertSome($this->validator->validate([
            "anpan" => $this->faker->word,
            "baba" => $this->faker->word,
            "cesnica" => $this->faker->word,
        ]));

        $this->assertNone($this->validator->validate([
            "baba" => $this->faker->word,
            "cesnica" => $this->faker->word,
        ]));

        $this->assertNone($this->validator->validate([]));
    }

    public function testOptionalParameters() {
        $this->assertSome($this->validator->validate([
            "anpan" => $this->faker->word,
            "baba" => $this->faker->word,
            "cesnica" => $this->faker->word,
            "eggette" => $this->faker->word,
        ]));
    }

    public function testIncorrectParameters() {
        $this->assertNone($this->validator->validate([
            "anpan" => $this->faker->word,
            "baba" => $this->faker->word,
            "cesnica" => $this->faker->word,
            "incorrect" => $this->faker->word,
        ]));

        $this->assertNone($this->validator->validate([
            "anpan" => $this->faker->word,
            "baba" => $this->faker->word,
            "cesnica" => $this->faker->word,
            "incorrect" => $this->faker->word,
        ]));
    }

    public function testVariousTypes() {
        $this->assertSome($this->validator->validate([
            "anpan" => $this->faker->word,
            "baba" => $this->faker->word,
            "cesnica" => [],
        ]));

        $this->assertSome($this->validator->validate([
            "anpan" => $this->faker->word,
            "baba" => $this->faker->word,
            "cesnica" => $this->faker->randomNumber(),
        ]));
    }
}
