<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Throwable;

final readonly class ExceptionHandlerRenderForConsoleExpectation
{
    public function __construct(
        public mixed $output,
        public Throwable $e,
    ) {
    }
}
