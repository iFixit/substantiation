<?php

declare(strict_types=1);

namespace Substantiation\Tests;

use Optional\Either;
use PHPUnit\Framework\Constraint\Constraint;

class IsSome extends Constraint {
    public function matches($other): bool {
        return ($other instanceof Either) && $other->hasValue();
    }

    public function toString(): string {
        return 'is Some';
    }
}
