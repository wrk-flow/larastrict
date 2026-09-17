<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use Closure;

final readonly class TestListenerCallsContractHandleExpectation
{
    /**
     * @param Closure(TestEvent,self):void|null $hook
     */
    public function __construct(
        public TestEvent $event,
        public ?Closure $hook = null,
    ) {
    }
}
