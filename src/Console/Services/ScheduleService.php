<?php

declare(strict_types=1);

namespace LaraStrict\Console\Services;

use Illuminate\Console\Application;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule as LaravelSchedule;
use Illuminate\Container\Container;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Console\Jobs\CommandInQueueJob;
use Symfony\Component\Console\Command\Command;

/**
 * - Adds ability to force all commands in queue
 * - Force logging of output to running process.
 * - Ensure jobs are unique.
 * @internal
 */
class ScheduleService implements ScheduleServiceContract
{
    public function __construct(
        private readonly LaravelSchedule $schedule,
        private readonly Container $container,
    ) {
    }

    /**
     * @param array<array-key, mixed> $parameters
     */
    public function command(string $command, array $parameters = []): Event
    {
        return $this->schedule->command($command, $parameters);
    }

    public function queueCommand(
        string $command,
        array $keyedParameters = [],
        int $uniqueFor = 1800,
        string $queue = 'default',
    ): CallbackEvent {
        $job = new CommandInQueueJob($command, $keyedParameters, $uniqueFor);
        $job->queue = $queue;

        $event = $this->schedule->job($job);

        // Ensure that php artisan schedule:list will return correct data
        if (class_exists($command)) {
            $resolvedCommand = $this->container->make($command);
            assert($resolvedCommand instanceof Command);
            $name = $resolvedCommand->getName();
        } else {
            $name = $event->command;
        }

        assert(is_string($name));

        $event->command = Application::formatCommandString($name);
        $event->description = 'queued ' . $name;

        return $event;
    }

    /**
     * Add a new job callback event to the schedule. Must set $job->queue.
     */
    public function job(object|string $job, ?string $queue = null, ?string $connection = null): Event|CallbackEvent
    {
        return $this->schedule->job($job, $queue, $connection);
    }
}
