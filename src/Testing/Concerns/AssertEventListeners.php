<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Events\Dispatcher;
use PHPUnit\Framework\Assert;

trait AssertEventListeners
{
    /**
     * @param bool $disableWildcard You can receive un-wanted listener responses (like laravel-ray). By default, we will remove any wildcard event.
     */
    public function assertEventListeners(
        Application $app,
        object $event,
        string $contract,
        object $assert,
        array $expectedListenerResults = [null],
        bool $disableWildcard = true
    ): void {
        $app->bind(abstract: $contract, concrete: static fn () => $assert);

        /** @var Dispatcher $events */
        $events = $app->make(Dispatcher::class);

        if ($disableWildcard) {
            $events->forget('*');
        }

        $results = $events->dispatch($event);

        Assert::assertEquals($expectedListenerResults, $results);
    }
}
