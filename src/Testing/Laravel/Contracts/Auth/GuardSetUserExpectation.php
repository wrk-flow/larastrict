<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;

final readonly class GuardSetUserExpectation
{
    /**
     * @param Closure(Authenticatable, self):void|null $hook
     */
    public function __construct(
        public Authenticatable $user,
        public ?Closure $hook = null,
    ) {
    }
}
