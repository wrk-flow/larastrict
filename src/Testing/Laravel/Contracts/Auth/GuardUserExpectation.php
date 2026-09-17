<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;

final readonly class GuardUserExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public Authenticatable|null $return,
        public ?Closure $hook = null,
    ) {
    }
}
