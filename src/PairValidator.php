<?php

declare(strict_types=1);

namespace Substantiation;

use Substantiation\Validator;
use Optional\Option;

/**
 * @template Key
 * @template Data
 * @extends Validator<Option<Data>>
 */
interface PairValidator extends Validator {
    /**
     * Returns the key this validator is supposed to match against
     *
     * @return Key
     */
    public function getKey();
}
