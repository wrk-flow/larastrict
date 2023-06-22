<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryDecrementExpectation
{
    /**
     * @param Closure(mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public readonly int|bool $return,
        public readonly mixed $key,
        public readonly mixed $value = 1,
        public readonly ?Closure $hook = null,
    ) {
    }
}
