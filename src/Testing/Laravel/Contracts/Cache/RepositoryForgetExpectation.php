<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryForgetExpectation
{
    /**
     * @param Closure(mixed, self):void|null $hook
     */
    public function __construct(
        public bool $return,
        public mixed $key,
        public ?Closure $hook = null,
    ) {
    }
}
