<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final readonly class ResponseFactoryDownloadExpectation
{
    /**
     * @param Closure(mixed, mixed, array<array-key, mixed>, mixed, self):void|null $hook
     * @param array<array-key, mixed> $headers
     */
    public function __construct(
        public BinaryFileResponse $return,
        public mixed $file,
        public mixed $name = null,
        public array $headers = [],
        public mixed $disposition = 'attachment',
        public ?Closure $hook = null,
    ) {
    }
}
