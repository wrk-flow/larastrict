<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final readonly class GateDeniesExpectation
{
    public function __construct(
        public bool $return,
        public mixed $ability,
        public mixed $arguments = [],
    ) {
    }
}
