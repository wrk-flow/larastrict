<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Jobs\Job;

final readonly class RunOrQueueJobActionContractExpectation
{
    /**
     * @param Closure(Job, Command|null, Closure(Job):void|null, bool|null, self):void|null $_hook
     */
    public function __construct(
        public mixed $return,
        public Job $job,
        public ?Command $command = null,
        public ?Closure $setupBeforeRun = null,
        public ?bool $shouldQueue = null,
        public ?Closure $_hook = null,
    ) {
    }
}
