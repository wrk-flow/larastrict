<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final class GatePolicyExpectation
{
    public function __construct(
        public readonly mixed $class,
        public readonly mixed $policy,
    ) {
    }
}
