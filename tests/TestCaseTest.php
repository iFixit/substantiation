<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Optional\Either;
use PHPUnit\Framework\AssertionFailedError;

class TestCaseTest extends TestCase {
    public function testAssertSome() {
        $this->assertSome(Either::some(0));
    }

    public function testAssertSomeNone() {
        $this->expectException(AssertionFailedError::class);
        $this->assertSome(Either::none(0));
    }

    public function testAssertNone() {
        $this->assertNone(Either::none(0));
    }

    public function testAssertNoneSome() {
        $this->expectException(AssertionFailedError::class);
        $this->assertNone(Either::some(0));
    }
}
