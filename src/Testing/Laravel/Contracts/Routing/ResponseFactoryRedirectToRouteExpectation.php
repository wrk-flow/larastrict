<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;

final class ResponseFactoryRedirectToRouteExpectation
{
    /**
     * @param Closure(mixed, mixed, mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $route,
        public readonly mixed $parameters = [],
        public readonly mixed $status = 302,
        public readonly mixed $headers = [],
        public readonly ?Closure $hook = null,
    ) {
    }
}
