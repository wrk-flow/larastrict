<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Illuminate\Http\Response;

final readonly class ResponseFactoryNoContentExpectation
{
    /**
     * @param Closure(mixed, array<array-key, mixed>, self):void|null $hook
     * @param array<array-key, mixed> $headers
     */
    public function __construct(
        public Response $return,
        public mixed $status = 204,
        public array $headers = [],
        public ?Closure $hook = null,
    ) {
    }
}
