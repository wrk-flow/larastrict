<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryGetExpectation
{
    /**
     * @param Closure(string, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly string $key,
        public readonly mixed $default = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
