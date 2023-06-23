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
        $app = $this->app();

        $app->bind(TestListenerContract::class, TestListener::class);
        $app->bind(TestListenerContract::class, TestListener::class);

        /** @var Dispatcher $events */
        $events = $app->get(Dispatcher::class);
        $events->listen(TestEvent::class, TestListenerContract::class);
        $events->listen(TestEvent::class, TestListenerCallsContract::class);
        // Should not be called - it will be un-registered.
        $events->listen(TestEvent::class, TestListenerCallsContractAssert::class);

        $event = new TestEvent();
        $this->assertEventListeners(
            app: $app,
            event: $event,
            contractMap: [
                TestListenerContract::class => new TestListenerContractAssert([
                    new TestListenerContractExpectation(event: $event),
                ]),
                TestListenerCallsContract::class => new TestListenerCallsContractAssert([
                    new TestListenerCallsContractHandleExpectation(event: $event),
                ]),
            ],
        );
    }
}
