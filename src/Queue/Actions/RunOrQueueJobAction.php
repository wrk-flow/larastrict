<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Actions;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Contracts\DispatchJobActionContract;
use LaraStrict\Queue\Contracts\RunJobActionContract;
use LaraStrict\Queue\Contracts\RunOrQueueJobActionContract;
use LaraStrict\Queue\Jobs\Job;

class RunOrQueueJobAction implements RunOrQueueJobActionContract
{
    public function __construct(
        private readonly RunJobActionContract $runJobAction,
        private readonly DispatchJobActionContract $dispatchJobAction
    ) {
    }

    /**
     * Allows to run or queue job based on the command option queue parameter or not providing a $command.
     *
     * @param Closure(Job):void|null $setupBeforeRun
     * @param bool|null $shouldQueue You can force to queue the job even if the command option queue is set.
     *
     * @return mixed If the job is queued, it returns null, otherwise it returns the result of the job execution.
     */
    public function execute(
        Job $job,
        ?Command $command = null,
        ?Closure $setupBeforeRun = null,
        ?bool $shouldQueue = null,
    ): mixed {
        if ($shouldQueue === true
            || $shouldQueue === null && (! $command instanceof Command || $command->option('queue') === true)) {
            $this->dispatchJobAction->execute($job);

            return null;
        }

        if ($setupBeforeRun instanceof Closure) {
            $setupBeforeRun($job);
        }

        return $this->runJobAction->execute(job: $job, command: $command);
    }
}
