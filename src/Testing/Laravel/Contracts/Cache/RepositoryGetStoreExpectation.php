<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;
use Illuminate\Contracts\Cache\Store;

final readonly class RepositoryGetStoreExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public Store $return,
        public ?Closure $hook = null,
    ) {
    }
}
