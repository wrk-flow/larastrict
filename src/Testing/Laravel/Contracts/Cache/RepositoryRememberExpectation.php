<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryRememberExpectation
{
    /**
     * @param Closure(mixed, mixed, Closure, self):void|null $hook
     */
    public function __construct(
        public mixed $return,
        public mixed $key,
        public mixed $ttl,
        public ?Closure $hook = null,
    ) {
    }
}
