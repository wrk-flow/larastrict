<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryClearExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public bool $return,
        public ?Closure $hook = null,
    ) {
    }
}
