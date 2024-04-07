<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;

final class GuardHasUserExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
