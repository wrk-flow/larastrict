<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\Events;

use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherAssert;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherDispatchExpectation;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherFlushExpectation;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherForgetExpectation;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherForgetPushedExpectation;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherHasListenersExpectation;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherListenExpectation;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherPushExpectation;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherSubscribeExpectation;
use LaraStrict\Testing\Laravel\Contracts\Events\DispatcherUntilExpectation;
use PHPUnit\Framework\TestCase;

class DispatcherAssertTest extends TestCase
{
    use AssertExpectations;

    protected function generateData(): array
    {
        return [
            new AssertExpectationEntity(
                methodName: 'listen',
                createAssert: static fn () => new DispatcherAssert(
                    listen: [new DispatcherListenExpectation(events: [TestEvent::class], listener: TestListener::class)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->listen(
                    events: [TestEvent::class],
                    listener: TestListener::class
                ),
            ),
            new AssertExpectationEntity(
                methodName: 'listen',
                createAssert: static fn () => new DispatcherAssert(
                    listen: [new DispatcherListenExpectation(events: [], listener: null)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->listen(events: []),
            ),
            new AssertExpectationEntity(
                methodName: 'listen',
                createAssert: static fn () => new DispatcherAssert(
                    listen: [new DispatcherListenExpectation(events: [TestEvent::class], listener: null)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->listen(events: [TestEvent::class]),
            ),
            new AssertExpectationEntity(
                methodName: 'hasListeners',
                createAssert: static fn () => new DispatcherAssert(
                    hasListeners: [new DispatcherHasListenersExpectation(return: true, eventName: 'test')]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->hasListeners(eventName: 'test'),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'hasListeners',
                createAssert: static fn () => new DispatcherAssert(
                    hasListeners: [new DispatcherHasListenersExpectation(return: false, eventName: TestEvent::class)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->hasListeners(eventName: TestEvent::class),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'subscribe',
                createAssert: static fn () => new DispatcherAssert(
                    subscribe: [new DispatcherSubscribeExpectation(subscriber: TestListener::class)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->subscribe(subscriber: TestListener::class),
            ),
            new AssertExpectationEntity(
                methodName: 'until',
                createAssert: static fn () => new DispatcherAssert(
                    until: [new DispatcherUntilExpectation(return: null, event: TestEvent::class, payload: ['test'])]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->until(
                    event: TestEvent::class,
                    payload: ['test']
                ),
                checkResult: true,
                expectedResult: null
            ),
            new AssertExpectationEntity(
                methodName: 'until',
                createAssert: static fn () => new DispatcherAssert(
                    until: [new DispatcherUntilExpectation(return: [], event: TestEvent::class)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->until(event: TestEvent::class),
                checkResult: true,
                expectedResult: []
            ),
            new AssertExpectationEntity(
                methodName: 'dispatch',
                createAssert: static fn () => new DispatcherAssert(
                    dispatch: [
                        new DispatcherDispatchExpectation(return: [], event: TestEvent::class, payload: [
                            'test',
                        ], halt: true),
                    ]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->dispatch(
                    event: TestEvent::class,
                    payload: ['test'],
                    halt: true
                ),
                checkResult: true,
                expectedResult: []
            ),
            new AssertExpectationEntity(
                methodName: 'dispatch',
                createAssert: static fn () => new DispatcherAssert(
                    dispatch: [
                        new DispatcherDispatchExpectation(return: null, event: TestEvent::class, payload: ['test']),
                    ]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->dispatch(
                    event: TestEvent::class,
                    payload: ['test']
                ),
                checkResult: true,
                expectedResult: null
            ),
            new AssertExpectationEntity(
                methodName: 'push',
                createAssert: static fn () => new DispatcherAssert(
                    push: [new DispatcherPushExpectation(event: TestEvent::class, payload: ['test'])]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->push(event: TestEvent::class, payload: ['test']),
            ),
            new AssertExpectationEntity(
                methodName: 'push',
                createAssert: static fn () => new DispatcherAssert(
                    push: [new DispatcherPushExpectation(event: TestEvent::class)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->push(event: TestEvent::class),
            ),
            new AssertExpectationEntity(
                methodName: 'flush',
                createAssert: static fn () => new DispatcherAssert(
                    flush: [new DispatcherFlushExpectation(event: TestEvent::class)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->flush(event: TestEvent::class),
            ),
            new AssertExpectationEntity(
                methodName: 'forget',
                createAssert: static fn () => new DispatcherAssert(
                    forget: [new DispatcherForgetExpectation(event: TestEvent::class)]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->forget(event: TestEvent::class),
            ),
            new AssertExpectationEntity(
                methodName: 'forgetPushed',
                createAssert: static fn () => new DispatcherAssert(
                    forgetPushed: [new DispatcherForgetPushedExpectation()]
                ),
                call: static fn (DispatcherAssert $assert) => $assert->forgetPushed(),
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new DispatcherAssert();
    }
}
