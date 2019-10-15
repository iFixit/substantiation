<?php

declare(strict_types=1);

namespace Substantiation\Shorthand;

use Substantiation\CallableValidator;
use Substantiation\PassValidator;
use Substantiation\FailValidator;
use Substantiation\RequiredPair;

/**
 * @template T
 * @param callable(T):bool $callable
 * @return CallableValidator<T>
 */
function call(callable $callable): CallableValidator {
    return new CallableValidator($callable);
}

function pass(): PassValidator {
    return new PassValidator();
}

function fail(): FailValidator {
    return new FailValidator();
}

function required($key, $value): RequiredPair {
    return new RequiredPair($key, $value);
}
