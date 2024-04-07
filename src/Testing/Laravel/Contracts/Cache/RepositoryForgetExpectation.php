<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final class RepositoryForgetExpectation
{
    /**
     * @param Closure(mixed, self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly mixed $key,
        public readonly ?Closure $hook = null,
    ) {
    }
}
