<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryGetStoreExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
