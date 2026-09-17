<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryGetExpectation
{
    /**
     * @param Closure(string, mixed, self):void|null $hook
     */
    public function __construct(
        public mixed $return,
        public string $key,
        public mixed $default = null,
        public ?Closure $hook = null,
    ) {
    }
}
