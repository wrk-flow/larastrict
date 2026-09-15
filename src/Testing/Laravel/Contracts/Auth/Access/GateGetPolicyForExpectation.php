<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final readonly class GateGetPolicyForExpectation
{
    public function __construct(
        public mixed $return,
        public mixed $class,
    ) {
    }
}
