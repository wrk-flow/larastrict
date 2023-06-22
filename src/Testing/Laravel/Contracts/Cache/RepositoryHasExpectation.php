<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryHasExpectation
{
    /**
     * @param Closure(string, self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly string $key,
        public readonly ?Closure $hook = null,
    ) {
    }
}
