<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;
use Illuminate\Contracts\Cache\Store;

final class RepositoryGetStoreExpectation
{
    /**
     * @param Closure(Store):void|null $hook
     */
    public function __construct(
        public readonly Store $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
