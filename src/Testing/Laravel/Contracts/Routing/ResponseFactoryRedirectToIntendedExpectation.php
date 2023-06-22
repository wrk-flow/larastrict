<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Closure;

final class ResponseFactoryRedirectToIntendedExpectation
{
    /**
     * @param Closure(mixed, mixed, mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $default = '/',
        public readonly mixed $status = 302,
        public readonly mixed $headers = [],
        public readonly mixed $secure = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
