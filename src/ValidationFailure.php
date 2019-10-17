<?php

declare(strict_types=1);

namespace Substantiation;

class ValidationFailure {
    public $cause;

    public function __construct(string $cause) {
        $this->cause = $cause;
    }
}
