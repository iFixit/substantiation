<?php

declare(strict_types=1);

namespace Substantiation;
use Substantiation\Validator;
use Substantiation\ValidationFailure;
use Optional\Either;

/**
 * @template Data
 * @implements Validator<Data>
 */
class CallableValidator implements Validator {
    private $callable;
    /**
     * @param callable(Data):bool $callable
     */
    public function __construct(callable $callable) {
        $this->callable = $callable;
    }

    public function validate($data): Either {
        if (($this->callable)($data)) {
            /** @var Either<Data, ValidationFailure> */
            return Either::some($data);
        } else {
            /** @var Either<Data, ValidationFailure> */
            return Either::none(new ValidationFailure(
             "{$this->callable} returned false"));
        }
    }
}
