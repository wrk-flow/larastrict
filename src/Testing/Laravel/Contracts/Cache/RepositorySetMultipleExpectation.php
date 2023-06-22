<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;
use DateInterval;

final class RepositorySetMultipleExpectation
{
    /**
     * @param Closure(iterable, (DateInterval | int | null), self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly iterable $values,
        public readonly DateInterval|int|null $ttl = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
