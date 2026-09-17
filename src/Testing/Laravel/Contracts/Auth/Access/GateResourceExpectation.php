<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final readonly class GateResourceExpectation
{
    /**
     * @param array<array-key, mixed> $abilities
     */
    public function __construct(
        public mixed $name,
        public mixed $class,
        public ?array $abilities = null,
    ) {
    }
}
