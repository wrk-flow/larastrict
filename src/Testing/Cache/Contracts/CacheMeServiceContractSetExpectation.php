<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use LaraStrict\Cache\Constants\CacheExpirations;
use LaraStrict\Cache\Enums\CacheMeStrategy;

final class CacheMeServiceContractSetExpectation
{
    public function __construct(
        public readonly string $key,
        public readonly mixed $value,
        public readonly array $tags = [],
        public readonly int $minutes = CacheExpirations::HalfDay,
        public readonly CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
        public readonly bool $log = true,
    ) {
    }
}
