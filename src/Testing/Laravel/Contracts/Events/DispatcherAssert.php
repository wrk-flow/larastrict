<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

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

    public function listen($events, $listener = null)
    {
        $expectation = $this->getExpectation(DispatcherListenExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->events, $events, $message);
        Assert::assertEquals($expectation->listener, $listener, $message);
    }

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

    public function until($event, $payload = [])
    {
        $expectation = $this->getExpectation(DispatcherUntilExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
        Assert::assertEquals($expectation->payload, $payload, $message);

        return $expectation->return;
    }

    public function dispatch($event, $payload = [], $halt = false)
    {
        $expectation = $this->getExpectation(DispatcherDispatchExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
        Assert::assertEquals($expectation->payload, $payload, $message);
        Assert::assertEquals($expectation->halt, $halt, $message);

        return $expectation->return;
    }

    public function push($event, $payload = [])
    {
        $expectation = $this->getExpectation(DispatcherPushExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
        Assert::assertEquals($expectation->payload, $payload, $message);
    }

    public function flush($event)
    {
        $expectation = $this->getExpectation(DispatcherFlushExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
    }

    public function forget($event)
    {
        $expectation = $this->getExpectation(DispatcherForgetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);
    }

    public function forgetPushed()
    {
        $this->getExpectation(DispatcherForgetPushedExpectation::class);
    }
}
