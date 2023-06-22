<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryGetMultipleExpectation
{
    /**
     * @param Closure(iterable, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly iterable $return,
        public readonly iterable $keys,
        public readonly mixed $default = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
