<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Events\Dispatcher;
use LaraStrict\Testing\AbstractExpectationCallMap;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

trait AssertEventListeners
{
    /**
     * @template T of AbstractExpectationCallsMap|AbstractExpectationCallMap
     * @param array<class-string, T> $contractMap
     * @param bool $disableWildcard You can receive un-wanted listener responses (like laravel-ray). By default, we will remove any wildcard event.
     * @param array|null $expectedListenerResults By default, assert returns nothing, we will auto populate nulls based on
     */
    public function assertEventListeners(
        Application $app,
        object $event,
        array $contractMap,
        ?array $expectedListenerResults = null,
        bool $disableWildcard = true
    ): void {
        $shouldBuildResults = $expectedListenerResults === null;

        if ($shouldBuildResults) {
            $expectedListenerResults = [];
        }

        $asserts = [];

        foreach ($contractMap as $contract => $assert) {
            if ($shouldBuildResults) {
                $expectedListenerResults[] = null;
            }

            $asserts[] = $assert;

            $app->bind(abstract: $contract, concrete: static fn () => $assert);
        }

        /** @var Dispatcher $events */
        $events = $app->make(Dispatcher::class);

        if ($disableWildcard) {
            $events->forget('*');
        }

        $results = $events->dispatch($event);

        Assert::assertEquals($expectedListenerResults, $results);

        foreach ($asserts as $assert) {
            if ($assert instanceof AbstractExpectationCallsMap) {
                $assert->assertCalled();
            }
        }
    }
}
