<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;
use DateInterval;
use DateTimeInterface;

final readonly class RepositoryTouchExpectation
{
    /**
     * @param Closure(mixed, DateTimeInterface|DateInterval|int, self):void|null $hook
     */
    public function __construct(
        public bool $return,
        public mixed $key,
        public DateTimeInterface|DateInterval|int $ttl,
        public ?Closure $hook = null,
    ) {
    }
}
