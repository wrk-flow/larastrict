<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Contracts;

use Illuminate\Console\Command;
use LaraStrict\Queue\Jobs\Job;

interface RunJobActionContract
{
    /**
     * Runs the job using container->call() method. If the job is an instance of UsesCommandInterface, it will set the
     * command. that you can use for advanced output.
     *
     * @return mixed Returns the result of the job
     */
    public function execute(Job $job, ?Command $command = null, string $method = null): mixed;
}
