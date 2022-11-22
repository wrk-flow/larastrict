<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Throwable;

final class ExceptionHandlerShouldReportExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly Throwable $e,
    ) {
    }
}
