<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Throwable;

final class ExceptionHandlerRenderExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $request,
        public readonly Throwable $e,
    ) {
    }
}
