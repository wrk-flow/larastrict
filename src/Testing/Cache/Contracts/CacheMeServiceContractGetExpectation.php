<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use Closure;
use LaraStrict\Cache\Constants\CacheExpirations;
use LaraStrict\Cache\Enums\CacheMeStrategy;

final readonly class CacheMeServiceContractGetExpectation
{
    /**
     * @param Closure(Closure):mixed|null $callGetValueHook
     * @param array<array-key, mixed> $tags
     */
    public function __construct(
        public string $key,
        public array $tags = [],
        public int $minutes = CacheExpirations::Day,
        public CacheMeStrategy $strategy = CacheMeStrategy::MemoryAndRepository,
        public ?Closure $callGetValueHook = null,
        public bool $log = true,
    ) {
    }
}
