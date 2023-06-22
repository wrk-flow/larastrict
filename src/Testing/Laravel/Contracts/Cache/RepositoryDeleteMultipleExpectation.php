<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryDeleteMultipleExpectation
{
    /**
     * @param Closure(iterable, self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly iterable $keys,
        public readonly ?Closure $hook = null,
    ) {
    }
}
