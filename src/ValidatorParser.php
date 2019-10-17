<?php

declare(strict_types=1);

namespace Substantiation;
use Substantiation\Validator;
use Substantiation\PatternParser;
use Substantiation\PairValidator;

class ValidatorParser extends PatternVisitor {
    protected function targetType(): string {
        return Validator::class;
    }

    public function callable(callable $c) {
        return new CallableValidator($c);
    }

    public function target(object $p) {
        return $p;
    }

    public function array($p) {
        return new ArrayValidator($this->visit($p));
    }

    public function sequentialMapKey($key, $value) {
        $validator = $this->visit($value);
        if (! $validator instanceof PairValidator) {
            throw new InvalidValidatorException();
        }
        return $validator;
    }

    public function arbitraryMapKey($key, $value) {
        return new RequiredPair($key, $this->visit($value));
    }

    public function map(array $p) {
        return new MapValidator(...$p);
    }
}
