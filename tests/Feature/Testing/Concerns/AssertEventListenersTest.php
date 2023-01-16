<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use Illuminate\Events\Dispatcher;
use LaraStrict\Testing\Concerns\AssertEventListeners;
use Tests\LaraStrict\Feature\TestCase;

class AssertEventListenersTest extends TestCase
{
    use AssertEventListeners;

    public function testAssertEventListeners(): void
    {
        // Set the event as provided would
        /** @var Dispatcher $events */
        $events = $this->app()
            ->get(Dispatcher::class);
        $this->app()
            ->bind(TestListenerContract::class, TestListener::class);

        $events->listen(TestEvent::class, TestListenerContract::class);

        $event = new TestEvent();
        $this->assertEventListeners(
            app: $this->app(),
            event: $event,
            contract: TestListenerContract::class,
            assert: new TestListenerContractAssert([new TestListenerContractExpectation(event: $event)])
        );
    }
}
