<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Throwable;

final class ExceptionHandlerRenderForConsoleExpectation
{
    public function __construct(
        public readonly mixed $output,
        public readonly Throwable $e,
    ) {
    }
}
