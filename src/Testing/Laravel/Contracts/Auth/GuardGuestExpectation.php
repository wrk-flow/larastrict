<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;

final class GuardGuestExpectation
{
    /**
     * @param Closure(bool):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
