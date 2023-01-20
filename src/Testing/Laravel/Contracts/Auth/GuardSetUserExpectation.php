<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;

final class GuardSetUserExpectation
{
    /**
     * @param Closure(Authenticatable, self):void|null $hook
     */
    public function __construct(
        public readonly Authenticatable $user,
        public readonly ?Closure $hook = null,
    ) {
    }
}
