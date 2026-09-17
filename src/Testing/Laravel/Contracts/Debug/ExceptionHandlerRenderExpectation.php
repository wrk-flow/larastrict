<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

final readonly class ExceptionHandlerRenderExpectation
{
    public function __construct(
        public Response $return,
        public mixed $request,
        public Throwable $e,
    ) {
    }
}
