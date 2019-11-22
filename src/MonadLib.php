<?php

declare(strict_types=1);

namespace Substantiation;

use Optional\Either;

class MonadLib {
    /**
     * @template T
     * @template U
     * @param Either<T, U>[] $data
     * @return Either<T[], U>
     */
    public static function sequence(array $data): Either {
        /** @var Either<T[], U> */
        $folded = Either::some([]);
        foreach ($data as $value) {
            $folded = $folded->flatMap(
                /**
                 * @var callable(T[]): T[]
                 */
                function($arr) use ($value) {
                    return $value->map(function ($v) use ($arr) {
                        return array_merge($arr, [$v]);
                    });
                });
        }
        return $folded;
    }

    /**
     * @template T
     * @template U
     * @param list<Either<T, U>> $data
     * @return array{0: list<T>, 1: list<U>}
     */
    public static function partitionEithers(array $data): array {
        $lefts = [];
        $rights = [];
        foreach ($data as $value) {
            $value->match(
             function($l) use (&$lefts) {
                 $lefts[] = $l;
             },
             function($r) use (&$rights) {
                 $rights[] = $r;
             }
            );
        }
        return [$lefts, $rights];
    }

    /**
     * @template K
     * @template T
     * @template U
     * @param array<K, Either<T, U>> $data
     * @return array{0: array<K, T>, 1: array<K, U>}
     */
    public static function partitionEithersMap(array $data): array {
        $lefts = [];
        $rights = [];
        foreach ($data as $key => $value) {
            $value->match(
             function($l) use ($key, &$lefts) {
                 $lefts[$key] = $l;
             },
             function($r) use ($key, &$rights) {
                 $rights[$key] = $r;
             }
            );
        }
        return [$lefts, $rights];
    }
}
