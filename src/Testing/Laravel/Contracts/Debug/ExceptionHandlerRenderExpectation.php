<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ExceptionHandlerRenderExpectation
{
    public function __construct(
        public readonly Response $return,
        public readonly mixed $request,
        public readonly Throwable $e,
    ) {
    }
}
