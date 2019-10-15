<?php

namespace Substantiation;

use Optional\Either;
use Substantiation\ValidationFailure;

/**
 * @template Data
 */
interface Validator {
    /**
     * Runs validation on the data passed and returns an Either
     * containing either valid data or error information
     *
     * @param Data $data The data to validate
     * @return Either<Data, ValidationFailure>
     */
    public function validate($data): Either;
}
