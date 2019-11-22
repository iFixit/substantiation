<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Optional\Either;
use Substantiation\MonadLib;

class MonadLibTest extends TestCase {
    public function testSequence() {
        $this->assertSome(MonadLib::sequence([]));

        $this->assertOnSome(function($v) {
            $this->assertEquals(["fish"], $v);
        }, MonadLib::sequence([Either::some("fish")]));

        $this->assertOnNone(function($v) {
            $this->assertEquals("b", $v);
        }, MonadLib::sequence([
           Either::some("a"),
           Either::none("b"),
           Either::none("c")
        ]));
    }

    public function testPartitionEithers() {
        $this->assertEquals([[], []], MonadLib::partitionEithers([]));

        $this->assertEquals(
         [["fish"], []],
         MonadLib::partitionEithers([Either::some("fish")])
        );

        $this->assertEquals(
         [["a"], ["b", "c"]],
         MonadLib::partitionEithers([
           Either::some("a"),
           Either::none("b"),
           Either::none("c")
        ]));
    }

    public function testPartitionEithersOnMap() {
        $this->assertEquals([[], []], MonadLib::partitionEithersMap([]));

        $this->assertEquals(
         [["a" => "fish"], []],
         MonadLib::partitionEithersMap(["a" => Either::some("fish")])
        );

        $this->assertEquals(
         [["apple" => "a"], ["bee" => "b", "cat" => "c"]],
         MonadLib::partitionEithersMap([
           "apple" => Either::some("a"),
           "bee" => Either::none("b"),
           "cat" => Either::none("c")
        ]));
    }
}
