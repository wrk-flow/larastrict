<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Actions;

use LaraStrict\Queue\Contracts\DispatchChainJobsActionContract;
use LaraStrict\Queue\Contracts\DispatchJobActionContract;

class DispatchChainJobsAction implements DispatchChainJobsActionContract
{
    public function __construct(
        private readonly DispatchJobActionContract $dispatchJobAction,
    ) {
    }

    public function execute(array $jobs): bool
    {
        if ($jobs === []) {
            return false;
        }

        if (count($jobs) === 1) {
            return $this->dispatchJobAction->execute(reset($jobs));
        }

        $mainJob = array_shift($jobs);

        // After main job is done, chain our jobs
        $mainJob->chain($jobs);

        // Set the chain queue
        $mainJob->chainQueue = $mainJob->queue;

        // Dispatch chained job
        return $this->dispatchJobAction->execute($mainJob);
    }
}
