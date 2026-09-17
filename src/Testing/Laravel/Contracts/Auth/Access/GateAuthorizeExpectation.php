<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

use Illuminate\Auth\Access\Response;

final readonly class GateAuthorizeExpectation
{
    public function __construct(
        public Response|bool $return,
        public mixed $ability,
        public mixed $arguments = [],
    ) {
    }
}
