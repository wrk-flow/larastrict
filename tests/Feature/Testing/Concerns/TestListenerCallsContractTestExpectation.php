<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use Closure;

final class TestListenerCallsContractTestExpectation
{
    /**
     * @param Closure(self):void|null $hook
     */
    public function __construct(
        public readonly ?Closure $hook = null
    ) {
    }
}
