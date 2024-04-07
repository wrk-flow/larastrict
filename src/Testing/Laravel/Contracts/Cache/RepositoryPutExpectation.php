<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryPutExpectation
{
    /**
     * @param Closure(bool, mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly mixed $key,
        public readonly mixed $value,
        public readonly mixed $ttl = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
