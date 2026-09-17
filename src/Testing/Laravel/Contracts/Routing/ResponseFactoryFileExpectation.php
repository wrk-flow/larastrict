<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final readonly class ResponseFactoryFileExpectation
{
    /**
     * @param Closure(mixed, array<array-key, mixed>, self):void|null $hook
     * @param array<array-key, mixed> $headers
     */
    public function __construct(
        public BinaryFileResponse $return,
        public mixed $file,
        public array $headers = [],
        public ?Closure $hook = null,
    ) {
    }
}
