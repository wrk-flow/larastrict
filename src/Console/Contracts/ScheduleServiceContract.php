<?php

declare(strict_types=1);

namespace LaraStrict\Console\Contracts;

use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Event;

interface ScheduleServiceContract
{
    public function command(string $command, array $parameters = []): Event;

    /**
     * Use for long tasks - ensurers that the command is unique.
     *
     * @param string $command         Command signature or class
     * @param array  $keyedParameters You need to key the parameters by command signature
     */
    public function queueCommand(string $command, array $keyedParameters = [], int $uniqueFor = 1800): CallbackEvent;

    /**
     * Add a new job callback event to the schedule. Must set $job->queue.
     */
    public function job(object|string $job, ?string $queue = null, ?string $connection = null): Event|CallbackEvent;
}
