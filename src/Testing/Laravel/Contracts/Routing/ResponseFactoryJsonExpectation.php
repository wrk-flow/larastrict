<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;

final class ResponseFactoryJsonExpectation
{
    /**
     * @param Closure(mixed, mixed, array, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $data = [],
        public readonly mixed $status = 200,
        public readonly array $headers = [],
        public readonly mixed $options = 0,
        public readonly ?Closure $hook = null,
    ) {
    }
}
