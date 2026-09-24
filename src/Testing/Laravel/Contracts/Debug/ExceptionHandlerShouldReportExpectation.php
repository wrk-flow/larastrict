<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Throwable;

final readonly class ExceptionHandlerShouldReportExpectation
{
    public function __construct(
        public bool $return,
        public Throwable $e,
    ) {
    }
}
