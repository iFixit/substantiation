<?php

declare(strict_types=1);

namespace Substantiation\Shorthand;

use Substantiation\CallableValidator;

/**
 * @template T
 * @param callable(T):bool $callable
 * @return CallableValidator<T>
 */
function call(callable $callable): CallableValidator {
    return new CallableValidator($callable);
}
