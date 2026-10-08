<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use Closure;

final readonly class TestListenerCallsContractTestExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public ?Closure $hook = null,
    ) {
    }
}
