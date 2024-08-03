<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;

final class GuardValidateExpectation
{
    /**
     * @param Closure(array, self):void|null $hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly array $credentials = [],
        public readonly ?Closure $hook = null,
    ) {
    }
}
