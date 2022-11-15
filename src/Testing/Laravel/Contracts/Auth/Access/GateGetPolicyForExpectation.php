<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final class GateGetPolicyForExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $class,
    ) {
    }
}
