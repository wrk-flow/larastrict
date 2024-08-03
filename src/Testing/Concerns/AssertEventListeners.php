<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Events\Dispatcher;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

trait AssertEventListeners
{
    /**
     * @template T of AbstractExpectationCallsMap
     * @param array<class-string, T> $contractMap
     * @param bool $disableWildcard You can receive un-wanted listener responses (like laravel-ray). By default, we will remove any wildcard event.
     * @param array|null $expectedListenerResults By default, assert returns nothing, we will auto populate nulls based on
     */
    public function assertEventListeners(
        Application $app,
        object $event,
        array $contractMap,
        ?array $expectedListenerResults = null,
        bool $disableWildcard = true,
    ): void {
        $shouldBuildResults = $expectedListenerResults === null;

        if ($shouldBuildResults) {
            $expectedListenerResults = [];
        }

        $asserts = [];

        /**
         * The goal is to prevent other listeners from being called, so we will remove all listeners for the event and
         * validate if the desired listeners were registered. Then we will re-register the listener we want and call the
         * event again to validate the results.
         */
        $events = $app->make(Dispatcher::class);
        assert($events instanceof Dispatcher);

        $rawListeners = $events->getRawListeners()[$event::class] ?? [];

        // Closures are not support, we cant use array_flip
        $currentListenersMap = [];
        foreach ($rawListeners as $listener) {
            if (is_string($listener)) {
                $currentListenersMap[$listener] = true;
            }
        }

        $events->forget($event::class);

        foreach ($contractMap as $contract => $assert) {
            if ($shouldBuildResults) {
                $expectedListenerResults[] = null;
            }

            // Listener must be registered for the event, if not we will fail
            Assert::assertArrayHasKey(
                $contract,
                $currentListenersMap,
                sprintf('Listener not %s registered for event: %s', $contract, $event::class),
            );

            $asserts[] = $assert;

            $app->bind(abstract: $contract, concrete: static fn () => $assert);

            $events->listen($event::class, $contract);
        }

        if ($disableWildcard) {
            $events->forget('*');
        }

        $results = $events->dispatch($event);

        Assert::assertEquals($expectedListenerResults, $results);

        foreach ($asserts as $assert) {
            $assert->assertCalled();
        }
    }
}
