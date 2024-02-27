<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Jobs\Job;

final class RunOrQueueJobActionContractExpectation
{
    /**
     * @param Closure(Job, Command, Closure, bool, self):void|null $_hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly Job $job,
        public readonly ?Command $command = null,
        public readonly ?Closure $setupBeforeRun = null,
        public readonly ?bool $shouldQueue = null,
        public readonly ?Closure $_hook = null,
    ) {
    }
}
