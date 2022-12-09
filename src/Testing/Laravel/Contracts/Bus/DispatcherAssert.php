<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

use Illuminate\Contracts\Bus\Dispatcher;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class DispatcherAssert extends AbstractExpectationCallsMap implements Dispatcher
{
    /**
     * @param array<DispatcherDispatchExpectation> $dispatch
     * @param array<DispatcherDispatchSyncExpectation> $dispatchSync
     * @param array<DispatcherDispatchNowExpectation> $dispatchNow
     * @param array<DispatcherHasCommandHandlerExpectation> $hasCommandHandler
     * @param array<DispatcherGetCommandHandlerExpectation> $getCommandHandler
     * @param array<DispatcherPipeThroughExpectation> $pipeThrough
     * @param array<DispatcherMapExpectation> $map
     */
    public function __construct(
        array $dispatch = [],
        array $dispatchSync = [],
        array $dispatchNow = [],
        array $hasCommandHandler = [],
        array $getCommandHandler = [],
        array $pipeThrough = [],
        array $map = [],
    ) {
        $this->setExpectations(DispatcherDispatchExpectation::class, array_values(array_filter($dispatch)));
        $this->setExpectations(DispatcherDispatchSyncExpectation::class, array_values(array_filter($dispatchSync)));
        $this->setExpectations(DispatcherDispatchNowExpectation::class, array_values(array_filter($dispatchNow)));
        $this->setExpectations(
            DispatcherHasCommandHandlerExpectation::class,
            array_values(array_filter($hasCommandHandler))
        );
        $this->setExpectations(
            DispatcherGetCommandHandlerExpectation::class,
            array_values(array_filter($getCommandHandler))
        );
        $this->setExpectations(DispatcherPipeThroughExpectation::class, array_values(array_filter($pipeThrough)));
        $this->setExpectations(DispatcherMapExpectation::class, array_values(array_filter($map)));
    }

    /**
     * Dispatch a command to its appropriate handler.
     *
     * @param  mixed  $command
     * @return mixed
     */
    public function dispatch($command)
    {
        $expectation = $this->getExpectation(DispatcherDispatchExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->command, $command, $message);

        return $expectation->return;
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * Queueable jobs will be dispatched to the "sync" queue.
     *
     * @param  mixed  $command
     * @param  mixed  $handler
     * @return mixed
     */
    public function dispatchSync($command, $handler = null)
    {
        $expectation = $this->getExpectation(DispatcherDispatchSyncExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->command, $command, $message);
        Assert::assertEquals($expectation->handler, $handler, $message);

        return $expectation->return;
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @param  mixed  $command
     * @param  mixed  $handler
     * @return mixed
     */
    public function dispatchNow($command, $handler = null)
    {
        $expectation = $this->getExpectation(DispatcherDispatchNowExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->command, $command, $message);
        Assert::assertEquals($expectation->handler, $handler, $message);

        return $expectation->return;
    }

    /**
     * Determine if the given command has a handler.
     *
     * @param  mixed  $command
     * @return bool
     */
    public function hasCommandHandler($command)
    {
        $expectation = $this->getExpectation(DispatcherHasCommandHandlerExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->command, $command, $message);

        return $expectation->return;
    }

    /**
     * Retrieve the handler for a command.
     *
     * @param  mixed  $command
     * @return bool|mixed
     */
    public function getCommandHandler($command)
    {
        $expectation = $this->getExpectation(DispatcherGetCommandHandlerExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->command, $command, $message);

        return $expectation->return;
    }

    /**
     * Set the pipes commands should be piped through before dispatching.
     *
     * @return $this
     */
    public function pipeThrough(array $pipes)
    {
        $expectation = $this->getExpectation(DispatcherPipeThroughExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->pipes, $pipes, $message);

        return $this;
    }

    /**
     * Map a command to a handler.
     *
     * @return $this
     */
    public function map(array $map)
    {
        $expectation = $this->getExpectation(DispatcherMapExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->map, $map, $message);

        return $this;
    }
}
