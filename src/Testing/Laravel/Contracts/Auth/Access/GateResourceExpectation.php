<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final class GateResourceExpectation
{
    public function __construct(
        public readonly mixed $name,
        public readonly mixed $class,
        public readonly ?array $abilities = null,
    ) {
    }
}
