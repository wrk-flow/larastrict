<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryForeverExpectation
{
    /**
     * @param Closure(string, mixed, self):void|null $hook
     */
    public function __construct(
        public bool $return,
        public mixed $key,
        public mixed $value,
        public ?Closure $hook = null,
    ) {
    }
}
