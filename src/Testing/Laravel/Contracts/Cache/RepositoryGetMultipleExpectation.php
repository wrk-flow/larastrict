<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryGetMultipleExpectation
{
    /**
     * @param Closure(iterable<string>, mixed, self):void|null $hook
     * @param iterable<string> $keys
     * @param iterable<string, mixed> $return
     */
    public function __construct(
        public iterable $return,
        public iterable $keys,
        public mixed $default = null,
        public ?Closure $hook = null,
    ) {
    }
}
