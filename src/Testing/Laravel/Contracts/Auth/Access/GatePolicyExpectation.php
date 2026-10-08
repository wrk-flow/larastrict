<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final readonly class GatePolicyExpectation
{
    public function __construct(
        public mixed $class,
        public mixed $policy,
    ) {
    }
}
