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

/**
 * - Adds ability to force all commands in queue
 * - Force logging of output to running process.
 * - Ensure jobs are unique.
 */
class ScheduleServiceService implements ScheduleServiceContract
{
    public function __construct(
        private readonly LaravelSchedule $schedule,
        private readonly Container $container
    ) {
    }

    public function command(string $command, array $parameters = []): Event
    {
        $event = $this->schedule->command($command, $parameters);

        $this->logEvent($event);

        return $event;
    }

    /**
     * Use for long tasks - ensurers that the command is unique.
     *
     * @param string $command         Command signature or class
     * @param array<string, string|float|int|bool>  $keyedParameters You need to key the parameters by command signature
     */
    public function queueCommand(
        string $command,
        array $keyedParameters = [],
        int $uniqueFor = 1800,
        string $queue = 'default'
    ): CallbackEvent {
        $job = new CommandInQueueJob($command, $keyedParameters, $uniqueFor);
        $job->queue = $queue;

        $event = $this->schedule->job($job);

        // Ensure that php artisan schedule:list will return correct data
        $name = class_exists($command) ? $this->container->make($command)
            ->getName() : $event->command;

        $event->command = Application::formatCommandString($name);
        $event->description = 'queued ' . $name;

        $this->logEvent($event);

        return $event;
    }

    /**
     * Add a new job callback event to the schedule. Must set $job->queue.
     */
    public function job(object|string $job, ?string $queue = null, ?string $connection = null): Event|CallbackEvent
    {
        $event = $this->schedule->job($job, $queue, $connection);

        $this->logEvent($event);

        return $event;
    }

    private function logEvent(Event|CallbackEvent $event): void
    {
        // Always output to docker output. Env?
        $event->appendOutputTo('/proc/1/fd/2');
    }
}
