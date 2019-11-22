<?php

declare(strict_types=1);

namespace Substantiation\Tests;

class TestCase extends \PHPUnit\Framework\TestCase {
    public function setUp(): void {
        parent::setUp();
        $this->faker = \Faker\Factory::create();
    }

    public static function assertSome($either, $message = '') {
        self::assertThat($either, self::isSome(), $message);
    }

    public static function assertNone($either, $message = '') {
        self::assertThat($either, self::isNone(), $message);
    }

    public static function assertOnSome($func, $either, $message = '') {
        self::assertSome($either);
        $either->matchSome($func);
    }

    public static function assertOnNone($func, $either, $message = '') {
        self::assertNone($either);
        $either->matchNone($func);
    }

    public static function isSome() {
        return new IsSome();
    }

    public static function isNone() {
        return new IsNone();
    }
}
