<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final class GateDefineExpectation
{
    public function __construct(
        public readonly mixed $ability,
        public readonly mixed $callback,
    ) {
    }
}
