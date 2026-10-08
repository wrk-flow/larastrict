<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryPutExpectation
{
    /**
     * @param Closure(string, mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public bool $return,
        public mixed $key,
        public mixed $value,
        public mixed $ttl = null,
        public ?Closure $hook = null,
    ) {
    }
}
