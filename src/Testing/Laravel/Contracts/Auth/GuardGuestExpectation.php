<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;

final readonly class GuardGuestExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public bool $return,
        public ?Closure $hook = null,
    ) {
    }
}
