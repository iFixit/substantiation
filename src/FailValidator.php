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
class FailValidator implements Validator {
    public function validate($data): Either {
        /** @var Either<Data, ValidationFailure> */
        return Either::none(new ValidationFailure());
    }
}
