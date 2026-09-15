<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final readonly class GateDefineExpectation
{
    public function __construct(
        public mixed $ability,
        public mixed $callback,
    ) {
    }
}
