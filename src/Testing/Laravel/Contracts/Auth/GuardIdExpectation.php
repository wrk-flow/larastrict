<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;

final readonly class GuardIdExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public int|string|null $return,
        public ?Closure $hook = null,
    ) {
    }
}
