<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Cache\Contracts;

use Closure;

final class CacheMeServiceContractObserveAndFlushExpectation
{
    public function __construct(
        public readonly Closure|array $tags,
        public readonly string $modelClass,
    ) {
    }
}
