<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryDecrementExpectation
{
    /**
     * @param Closure(mixed, mixed, self):void|null $hook
     */
    public function __construct(
        public int|bool $return,
        public mixed $key,
        public mixed $value = 1,
        public ?Closure $hook = null,
    ) {
    }
}
