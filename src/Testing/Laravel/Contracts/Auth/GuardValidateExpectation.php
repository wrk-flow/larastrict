<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Closure;

final readonly class GuardValidateExpectation
{
    /**
     * @param Closure(array<array-key, mixed>, self):void|null $hook
     * @param array<array-key, mixed> $credentials
     */
    public function __construct(
        public bool $return,
        public array $credentials = [],
        public ?Closure $hook = null,
    ) {
    }
}
