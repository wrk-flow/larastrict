<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use LaraStrict\Cache\Enums\CacheMeStrategy;

final class CacheMeServiceContractDeleteExpectation
{
    public function __construct(
        public readonly string $key,
        public readonly array $tags = [],
        public readonly CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
    ) {
    }
}
