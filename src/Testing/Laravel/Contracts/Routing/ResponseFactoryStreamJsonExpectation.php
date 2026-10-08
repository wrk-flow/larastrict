<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;

final readonly class ResponseFactoryStreamJsonExpectation
{
    /**
     * @param Closure(array<array-key, mixed>, mixed, array<array-key, mixed>, mixed, self):void|null $hook
     * @param array<array-key, mixed> $data
     * @param array<array-key, mixed> $headers
     */
    public function __construct(
        public StreamedJsonResponse $return,
        public array $data,
        public mixed $status = 200,
        public array $headers = [],
        public mixed $encodingOptions = 15,
        public ?Closure $hook = null,
    ) {
    }
}
