<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;

final class ResponseFactoryFileExpectation
{
    /**
     * @param Closure(mixed, array, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $file,
        public readonly array $headers = [],
        public readonly ?Closure $hook = null,
    ) {
    }
}
