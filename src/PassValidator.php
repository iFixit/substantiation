<?php

declare(strict_types=1);

namespace Substantiation;

use Substantiation\Validator;
use Optional\Either;

/**
 * @template Data
 * @implements Validator<Data>
 */
class PassValidator implements Validator {
    public function validate($data): Either {
        /** @var Either<Data, ValidationFailure> */
        return Either::some($data);
    }
}
