<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Throwable;

final readonly class ExceptionHandlerReportExpectation
{
    public function __construct(
        public Throwable $e,
    ) {
    }
}
