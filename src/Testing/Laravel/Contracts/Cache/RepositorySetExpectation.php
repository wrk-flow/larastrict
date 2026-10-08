<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;
use DateInterval;

final readonly class RepositorySetExpectation
{
    /**
     * @param Closure(string, mixed, (DateInterval|int|null), self):void|null $hook
     */
    public function __construct(
        public bool $return,
        public string $key,
        public mixed $value,
        public DateInterval|int|null $ttl = null,
        public ?Closure $hook = null,
    ) {
    }
}
