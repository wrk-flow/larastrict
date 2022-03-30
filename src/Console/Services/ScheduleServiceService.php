<?php

declare(strict_types=1);

namespace Larastrict\Console\Services;

use Illuminate\Console\Application;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule as LaravelSchedule;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Larastrict\Console\Contracts\ScheduleServiceContract;
use Larastrict\Console\Jobs\CommandInQueueJob;

/**
 * - Adds ability to force all commands in queue
 * - Force logging of output to running process.
 * - Ensure jobs are unique.
 */
class ScheduleServiceService implements ScheduleServiceContract
{
    private LaravelSchedule $schedule;
    private Container $container;

    public function __construct(LaravelSchedule $schedule, Container $container)
    {
        $this->schedule = $schedule;
        $this->container = $container;
    }

    public function command(string $command, array $parameters = []): Event
    {
        $event = $this->schedule->command($command, $parameters);

        return $this->logEvent($event);
    }

    /**
     * Use for long tasks - ensurers that the command is unique.
     *
     * @param string $command         Command signature or class
     * @param array  $keyedParameters You need to key the parameters by command signature
     *
     * @throws BindingResolutionException
     */
    public function queueCommand(string $command, array $keyedParameters = []): CallbackEvent
    {
        $job = new CommandInQueueJob($command, $keyedParameters);
        $event = $this->schedule->job($job);

        // Ensure that php artisan schedule:list will return correct data
        if (class_exists($command)) {
            $name = $this->container->make($command)->getName();
        } else {
            $name = $event->command;
        }

        $event->command = Application::formatCommandString($name);

        return $this->logEvent($event);
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

    private function logEvent(Event $event): Event|CallbackEvent
    {
        // Always output to docker output. Env?
        $event->appendOutputTo('/proc/1/fd/2');

        return $event;
    }
}
