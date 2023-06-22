<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryPullExpectation
{
    /**
     * @param Closure(mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $key,
        public readonly mixed $default = null,
        public readonly ?Closure $hook = null,
    ) {
    }
}
