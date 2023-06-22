<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryRememberExpectation
{
    /**
     * @param Closure(mixed, mixed, Closure, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $key,
        public readonly mixed $ttl,
        public readonly ?Closure $hook = null,
    ) {
    }
}
