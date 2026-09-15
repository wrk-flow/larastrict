<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryDeleteMultipleExpectation
{
    /**
     * @param Closure(iterable<mixed>, self):void|null $hook
     * @param iterable<mixed> $keys
     */
    public function __construct(
        public bool $return,
        public iterable $keys,
        public ?Closure $hook = null,
    ) {
    }
}
