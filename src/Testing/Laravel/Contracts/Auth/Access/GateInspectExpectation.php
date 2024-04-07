<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

use Illuminate\Auth\Access\Response;

final class GateInspectExpectation
{
    public function __construct(
        public readonly Response $return,
        public readonly mixed $ability,
        public readonly mixed $arguments = [],
    ) {
    }
}
