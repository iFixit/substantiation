<?php

declare(strict_types=1);

namespace Substantiation;

use Substantiation\Validator;
use Substantiation\PairValidator;
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
    }

    public function validate($data): Either {
        $extraKeys = array_diff(array_keys($data), $this->getKeys());
        if ($extraKeys) {
            return Either::none(new ValidationFailure());
        }

        $folded = Either::some([]);
        foreach ($this->validators as $validator) {
            $folded = $folded->flatMap(
                function($validated) use ($data, $validator) {
                    $value = Option::fromArray($data, $validator->getKey());
                    return $validator
                        ->validate($value)
                        ->map(function($v) use ($validated) {
                            return array_merge($validated, [$v]);
                        });
                }
            );
        }
        return $folded;
    }

    private function getKeys(): array {
        return array_map(function($v) {
            return $v->getKey();
        }, $this->validators);
    }
}
