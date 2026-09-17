<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Cache;

use Closure;

final readonly class RepositoryDeleteExpectation
{
    /**
     * @param Closure(string, self):void|null $hook
     */
    public function __construct(
        public bool $return,
        public string $key,
        public ?Closure $hook = null,
    ) {
    }
}
