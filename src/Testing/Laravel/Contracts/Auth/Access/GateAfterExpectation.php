<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

use Closure;

final class GateAfterExpectation
{
    public function __construct(
        public readonly Closure $callback
    ) {
    }
}
