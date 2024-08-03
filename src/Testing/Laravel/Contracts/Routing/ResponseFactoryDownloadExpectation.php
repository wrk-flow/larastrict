<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ResponseFactoryDownloadExpectation
{
    /**
     * @param Closure(mixed, mixed, array, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly BinaryFileResponse $return,
        public readonly mixed $file,
        public readonly mixed $name = null,
        public readonly array $headers = [],
        public readonly mixed $disposition = 'attachment',
        public readonly ?Closure $hook = null,
    ) {
    }
}
