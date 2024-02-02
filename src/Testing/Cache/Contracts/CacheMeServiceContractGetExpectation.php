<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use Closure;
use LaraStrict\Cache\Constants\CacheExpirations;
use LaraStrict\Cache\Enums\CacheMeStrategy;

final class CacheMeServiceContractGetExpectation
{
    /**
     * @param Closure(Closure):mixed|null $callGetValueHook
     */
    public function __construct(
        public readonly string $key,
        public readonly array $tags = [],
        public readonly int $minutes = CacheExpirations::Day,
        public readonly CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
        public readonly ?Closure $callGetValueHook = null,
        public readonly bool $log = true,
    ) {
    }
}
