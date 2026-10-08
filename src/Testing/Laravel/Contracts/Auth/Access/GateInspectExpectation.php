<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

use Illuminate\Auth\Access\Response;

final readonly class GateInspectExpectation
{
    public function __construct(
        public Response $return,
        public mixed $ability,
        public mixed $arguments = [],
    ) {
    }
}
