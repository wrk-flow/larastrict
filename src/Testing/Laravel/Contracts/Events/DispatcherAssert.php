<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

use Closure;
use Illuminate\Contracts\Events\Dispatcher;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class DispatcherAssert extends AbstractExpectationCallsMap implements Dispatcher
{
    /**
     * @param array<DispatcherListenExpectation> $listen
     * @param array<DispatcherHasListenersExpectation> $hasListeners
     * @param array<DispatcherSubscribeExpectation> $subscribe
     * @param array<DispatcherUntilExpectation> $until
     * @param array<DispatcherDispatchExpectation> $dispatch
     * @param array<DispatcherPushExpectation> $push
     * @param array<DispatcherFlushExpectation> $flush
     * @param array<DispatcherForgetExpectation> $forget
     * @param array<DispatcherForgetPushedExpectation> $forgetPushed
     */
    public function __construct(
        array $listen = [],
        array $hasListeners = [],
        array $subscribe = [],
        array $until = [],
        array $dispatch = [],
        array $push = [],
        array $flush = [],
        array $forget = [],
        array $forgetPushed = [],
    ) {
        $this->setExpectations(DispatcherListenExpectation::class, array_values(array_filter($listen)));
        $this->setExpectations(DispatcherHasListenersExpectation::class, array_values(array_filter($hasListeners)));
        $this->setExpectations(DispatcherSubscribeExpectation::class, array_values(array_filter($subscribe)));
        $this->setExpectations(DispatcherUntilExpectation::class, array_values(array_filter($until)));
        $this->setExpectations(DispatcherDispatchExpectation::class, array_values(array_filter($dispatch)));
        $this->setExpectations(DispatcherPushExpectation::class, array_values(array_filter($push)));
        $this->setExpectations(DispatcherFlushExpectation::class, array_values(array_filter($flush)));
        $this->setExpectations(DispatcherForgetExpectation::class, array_values(array_filter($forget)));
        $this->setExpectations(DispatcherForgetPushedExpectation::class, array_values(array_filter($forgetPushed)));
    }

    /**
     * Register an event listener with the dispatcher.
     *
     * @param Closure|string|array $events
     * @param Closure|string|array|null $listener
     */
    public function listen($events, $listener = null)
    {
        $expectation = $this->getExpectation(DispatcherListenExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->events, $events, $message);
        Assert::assertEquals($expectation->listener, $listener, $message);
    }

    /**
     * Determine if a given event has listeners.
     *
     * @param  string  $eventName
     * @return bool
     */
    public function hasListeners($eventName)
    {
        $expectation = $this->getExpectation(DispatcherHasListenersExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->eventName, $eventName, $message);

        return $expectation->return;
    }

    /**
     * Register an event subscriber with the dispatcher.
     *
     * @param  object|string  $subscriber
     */
    public function subscribe($subscriber)
    {
        $expectation = $this->getExpectation(DispatcherSubscribeExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->subscriber, $subscriber, $message);
    }

    /**
     * Dispatch an event until the first non-null response is returned.
     *
     * @param  string|object  $event
     * @param  mixed  $payload
     * @return array|null
     */
    public function until($event, $payload = [])
    {
        $expectation = $this->getExpectation(DispatcherUntilExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
        Assert::assertEquals($expectation->payload, $payload, $message);

        return $expectation->return;
    }

    /**
     * Dispatch an event and call the listeners.
     *
     * @param  string|object  $event
     * @param  mixed  $payload
     * @param  bool  $halt
     * @return array|null
     */
    public function dispatch($event, $payload = [], $halt = false)
    {
        $expectation = $this->getExpectation(DispatcherDispatchExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
        Assert::assertEquals($expectation->payload, $payload, $message);
        Assert::assertEquals($expectation->halt, $halt, $message);

        return $expectation->return;
    }

    /**
     * Register an event and payload to be fired later.
     *
     * @param  string  $event
     * @param  array  $payload
     */
    public function push($event, $payload = [])
    {
        $expectation = $this->getExpectation(DispatcherPushExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
        Assert::assertEquals($expectation->payload, $payload, $message);
    }

    /**
     * Flush a set of pushed events.
     *
     * @param  string  $event
     */
    public function flush($event)
    {
        $expectation = $this->getExpectation(DispatcherFlushExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
    }

    /**
     * Remove a set of listeners from the dispatcher.
     *
     * @param  string  $event
     */
    public function forget($event)
    {
        $expectation = $this->getExpectation(DispatcherForgetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
    }

    /**
     * Forget all of the queued listeners.
     */
    public function forgetPushed()
    {
        $expectation = $this->getExpectation(DispatcherForgetPushedExpectation::class);
    }
}
