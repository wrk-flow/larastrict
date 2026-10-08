<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositorySearExpectation
{
    /**
     * @param Closure(mixed, Closure, self):void|null $hook
     */
    public function __construct(
        public mixed $return,
        public mixed $key,
        public ?Closure $hook = null,
    ) {
    }
}
