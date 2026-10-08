<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use LaraStrict\Cache\Enums\CacheMeStrategy;

final readonly class CacheMeServiceContractDeleteExpectation
{
    /**
     * @param array<array-key, mixed> $tags
     */
    public function __construct(
        public string $key,
        public array $tags = [],
        public CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
    ) {
    }
}
