<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final class GateCheckExpectation
{
    public function __construct(
        public readonly bool $return,
        public readonly mixed $abilities,
        public readonly mixed $arguments = [],
    ) {
    }
}
