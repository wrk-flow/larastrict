<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Throwable;

final class ExceptionHandlerReportExpectation
{
    public function __construct(
        public readonly Throwable $e,
    ) {
    }
}
