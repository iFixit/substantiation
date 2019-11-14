<?php

declare(strict_types=1);

namespace Substantiation;

abstract class PatternVisitor {
    abstract public function callable(callable $p);
    abstract public function array($p);
    abstract public function target(object $p);
    public function map(array $p) {
        return $p;
    }
    abstract public function sequentialMapKey(int $key, $value);
    abstract public function arbitraryMapKey($key, $value);

    abstract protected function targetType(): string;

    public function visit($p) {
        if (is_callable($p)) {
            return $this->callable($p);
        }

        if (is_array($p)) {
            if (array_keys($p) === [0]) {
                return $this->array($p[0]);
            } else {
                return $this->mapPairs($p);
            }
        }

        $target = $this->targetType();
        if ($p instanceof $target) {
            return $this->target($p);
        }

        $pat = var_export($p, true);
        throw new \RuntimeException("Invalid pattern: `$pat`");
    }

    private function mapPairs(array $p) {
        $results = [];
        $seq = 0;
        foreach ($p as $key => $value) {
            if ($key === $seq) {
                $results[] = $this->sequentialMapKey($key, $value);
                $seq++;
            } else {
                if (is_int($key)) {
                    $seq = $key + 1;
                }
                $results[] = $this->arbitraryMapKey($key, $value);
            }
        }
        return $this->map($results);

    }
}
