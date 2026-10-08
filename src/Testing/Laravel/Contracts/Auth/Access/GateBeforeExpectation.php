<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

use Closure;

final readonly class GateBeforeExpectation
{
    public function __construct(
        public Closure $callback,
    ) {
    }
}
