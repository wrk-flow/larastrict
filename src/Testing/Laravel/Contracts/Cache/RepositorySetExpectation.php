<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;
use DateInterval;

final class RepositorySetExpectation
{
    /**
     * @param Closure(string, mixed, (DateInterval | int | null), self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly string $key,
        public readonly mixed $value,
        public readonly DateInterval|int|null $ttl = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
