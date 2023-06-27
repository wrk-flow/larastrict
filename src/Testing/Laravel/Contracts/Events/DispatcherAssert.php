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
     * @param array<DispatcherListenExpectation|null> $listen
     * @param array<DispatcherHasListenersExpectation|null> $hasListeners
     * @param array<DispatcherSubscribeExpectation|null> $subscribe
     * @param array<DispatcherUntilExpectation|null> $until
     * @param array<DispatcherDispatchExpectation|null> $dispatch
     * @param array<DispatcherPushExpectation|null> $push
     * @param array<DispatcherFlushExpectation|null> $flush
     * @param array<DispatcherForgetExpectation|null> $forget
     * @param array<DispatcherForgetPushedExpectation|null> $forgetPushed
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
        parent::__construct();
        $this->setExpectations(DispatcherListenExpectation::class, $listen);
        $this->setExpectations(DispatcherHasListenersExpectation::class, $hasListeners);
        $this->setExpectations(DispatcherSubscribeExpectation::class, $subscribe);
        $this->setExpectations(DispatcherUntilExpectation::class, $until);
        $this->setExpectations(DispatcherDispatchExpectation::class, $dispatch);
        $this->setExpectations(DispatcherPushExpectation::class, $push);
        $this->setExpectations(DispatcherFlushExpectation::class, $flush);
        $this->setExpectations(DispatcherForgetExpectation::class, $forget);
        $this->setExpectations(DispatcherForgetPushedExpectation::class, $forgetPushed);
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
