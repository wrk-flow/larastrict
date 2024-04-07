<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final class GateAbilitiesExpectation
{
    public function __construct(
        public readonly array $return
    ) {
    }
}
