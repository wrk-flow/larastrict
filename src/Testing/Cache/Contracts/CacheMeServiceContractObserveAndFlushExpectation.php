<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use Closure;

final readonly class CacheMeServiceContractObserveAndFlushExpectation
{
    /**
     * @param array<array-key, mixed> $tags
     */
    public function __construct(
        public Closure|array $tags,
        public string $modelClass,
    ) {
    }
}
