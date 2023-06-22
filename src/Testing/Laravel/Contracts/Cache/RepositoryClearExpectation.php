<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryClearExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
