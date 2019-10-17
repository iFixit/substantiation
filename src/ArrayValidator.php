<?php

declare(strict_types=1);

namespace Substantiation;

use Substantiation\Validator;
use Substantiation\MonadLib;
use Substantiation\ValidationFailure;
use Optional\Either;

class ArrayValidator implements Validator {
    private $validator;

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    public function validate($data): Either {
        if (!is_array($data)) {
            return Either::none(new ValidationFailure("Non-array passed"));
        }

        return MonadLib::sequence(array_map(function ($v) {
            return $this->validator->validate($v);
        }, $data));
    }
}
