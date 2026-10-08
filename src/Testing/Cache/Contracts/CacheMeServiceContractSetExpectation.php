<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use LaraStrict\Cache\Constants\CacheExpirations;
use LaraStrict\Cache\Enums\CacheMeStrategy;

final readonly class CacheMeServiceContractSetExpectation
{
    /**
     * @param array<array-key, mixed> $tags
     */
    public function __construct(
        public string $key,
        public mixed $value,
        public array $tags = [],
        public int $minutes = CacheExpirations::Day,
        public CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
        public bool $log = true,
    ) {
    }
}
