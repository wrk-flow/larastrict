<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use LaraStrict\Cache\Enums\CacheMeStrategy;

final readonly class CacheMeServiceContractFlushExpectation
{
    /**
     * @param array<array-key, mixed> $tags
     */
    public function __construct(
        public array $tags = [],
        public CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
    ) {
    }
}
