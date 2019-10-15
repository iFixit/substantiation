<?php

declare(strict_types=1);

namespace Substantiation;

use Substantiation\PairValidator;
use Optional\Either;
use Optional\Option;

/**
 * @template Key
 * @template Data
 * @implements PairValidator<Key, Data>
 */
class RequiredPair implements PairValidator {
    /** @var Key $key */
    private $key;

    /** @var Validator<Data> $value */
    private $value;

    /**
     * @param Key $key
     * @param Validator<Data> $value
     */
    public function __construct($key, Validator $value) {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey() {
        return $this->key;
    }

    public function validate($data): Either {
        // /** @psalm-suppress DocblockTypeContradiction */
        if (!$data instanceof Option) {
            /** @var Either<Optional<Data>, ValidationFailure> */
            throw new \TypeError("\$data not an instance of Option");
        }

        return $data->match(
            /**
             * @param Data $value
             * @return Either<Option<Data>, ValidationFailure>
             */
            function($value) {
                /**
                 * @var callable(Data):Option<Data>
                 */
                $some = \Closure::fromCallable([Option::class, 'some']);
                return $this->value
                    ->validate($value)
                    ->map($some);
            },
            /**
             * @return Either<Option<Data>, ValidationFailure>
             */
            function() {
                /** @var Either<Option<Data>, ValidationFailure> */
                return Either::none(new ValidationFailure());
            }
        );
    }
}
