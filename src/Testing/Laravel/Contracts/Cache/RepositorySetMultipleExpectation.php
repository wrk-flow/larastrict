<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;
use DateInterval;

final readonly class RepositorySetMultipleExpectation
{
    /**
     * @param Closure(iterable<mixed>, (DateInterval|int|null), self):void|null $hook
     * @param iterable<mixed> $values
     */
    public function __construct(
        public bool $return,
        public iterable $values,
        public DateInterval|int|null $ttl = null,
        public ?Closure $hook = null,
    ) {
    }
}
