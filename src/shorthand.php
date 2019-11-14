<?php

declare(strict_types=1);

namespace Substantiation\Shorthand;

use Optional\Either;

use Substantiation\Validator;
use Substantiation\ValidatorParser;
use Substantiation\CallableValidator;
use Substantiation\PassValidator;
use Substantiation\FailValidator;
use Substantiation\RequiredPair;
use Substantiation\OptionalPair;

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

function optional($key, $value): OptionalPair {
    return new OptionalPair($key, $value);
}

/**
 * @template Data
 * @param Validator $pattern The pattern to match against
 * @return Validator<Data>
 */
function validator($pattern): Validator {
    return (new ValidatorParser())->visit($pattern);
}

function validate($pattern, $value): Either {
    return validator($pattern)->validate($value);
}

function valid($pattern, $value): bool {
    return validate($pattern, $value)->hasValue();
}
