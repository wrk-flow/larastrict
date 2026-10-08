<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryPullExpectation
{
    /**
     * @param Closure(mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public mixed $return,
        public mixed $key,
        public mixed $default = null,
        public ?Closure $hook = null,
    ) {
    }
}
