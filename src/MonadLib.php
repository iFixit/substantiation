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
}
