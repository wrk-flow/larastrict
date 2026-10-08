<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Symfony\Component\HttpFoundation\StreamedResponse;

final readonly class ResponseFactoryStreamExpectation
{
    /**
     * @param Closure(mixed, mixed, array<array-key, mixed>, self):void|null $hook
     * @param array<array-key, mixed> $headers
     */
    public function __construct(
        public StreamedResponse $return,
        public mixed $status = 200,
        public array $headers = [],
        public ?Closure $hook = null,
    ) {
    }
}
