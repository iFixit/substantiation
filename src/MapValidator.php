<?php

declare(strict_types=1);

namespace Substantiation;

use Substantiation\Validator;
use Substantiation\ValidationFailure;
use Substantiation\PairValidator;
use Substantiation\MonadLib;
use Optional\Either;
use Optional\Option;

/**
 * @template Data
 * @implements Validator<Data>
 */
class MapValidator implements Validator {
    private $validators;

    /**
     * @param
     */
    public function __construct(PairValidator ...$validators) {
        $this->validators = $validators;

        $keys = $this->getKeys();
        $unique = array_unique($keys);
        if (count($unique) != count($keys)) {
            throw new InvalidValidatorException("Duplicate keys");
        }
    }

    public function validate($data): Either {
        if (!is_array($data)) {
            return Either::none(new ValidationFailure("Expected a map"));
        }

        $extraKeys = array_diff(array_keys($data), $this->getKeys());
        if ($extraKeys) {
            return Either::none(new ValidationFailure(count($extraKeys) . "extra keys"));
        }

        return MonadLib::sequence(array_map(function($validator) use ($data) {
            $value = Option::fromArray($data, $validator->getKey());
            return $validator->validate($value);
        }, $this->validators));
    }

    private function getKeys(): array {
        return array_map(function($v) {
            return $v->getKey();
        }, $this->validators);
    }
}
