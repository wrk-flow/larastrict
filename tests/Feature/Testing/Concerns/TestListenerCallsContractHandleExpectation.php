<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use Closure;

final class TestListenerCallsContractHandleExpectation
{
    /**
     * @param Closure(TestEvent,self):void|null $hook
     */
    public function __construct(
        public readonly TestEvent $event,
        public readonly ?Closure $hook = null,
    ) {
    }
}
