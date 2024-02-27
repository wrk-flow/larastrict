<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Contracts;

use LaraStrict\Queue\Jobs\Job;

interface DispatchChainJobsActionContract
{
    /**
     * Dispatches given chain of jobs (first job is used as main job and the rest are chained to it).
     *
     * If only one job is given, it will be dispatched directly.
     *
     * Ensures that the chainQueue is set to the main job's queue.
     *
     * @param Job[] $jobs
     *
     * @return bool True if the job was dispatched, false if the job was not dispatched.
     */
    public function execute(array $jobs): bool;
}
