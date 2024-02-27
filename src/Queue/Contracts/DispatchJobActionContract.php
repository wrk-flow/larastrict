<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Contracts;

use LaraStrict\Queue\Jobs\Job;

interface DispatchJobActionContract
{
    /**
     * Dispatch a job to the queue.
     * - Wraps a dispatch() method. It is used to
     */
    public function execute(Job $job): bool;
}
