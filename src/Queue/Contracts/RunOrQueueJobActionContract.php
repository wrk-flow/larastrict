<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Contracts;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Jobs\Job;

interface RunOrQueueJobActionContract
{
    /**
     * Allows to run or queue job based on the command option queue parameter or not providing a $command.
     *
     * @param Closure(Job):void|null $setupBeforeRun
     * @param bool|null              $shouldQueue You can force to queue the job even if the command option queue is
     * set.
     *
     * @return mixed If the job is queued, it returns null, otherwise it returns the result of the job execution.
     */
    public function execute(
        Job $job,
        ?Command $command = null,
        ?Closure $setupBeforeRun = null,
        ?bool $shouldQueue = null
    ): mixed;
}
