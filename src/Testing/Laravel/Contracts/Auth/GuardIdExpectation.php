<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;

final class GuardIdExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly int|string|null $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
