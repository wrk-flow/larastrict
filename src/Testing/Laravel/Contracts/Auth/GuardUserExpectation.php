<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;

final class GuardUserExpectation
{
    /**
     * @param Closure(Authenticatable|null):void|null $hook
     */
    public function __construct(
        public readonly Authenticatable|null $return,
        public readonly ?Closure $hook = null,
    ) {
    }
}
