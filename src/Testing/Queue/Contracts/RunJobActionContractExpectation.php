<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Jobs\Job;

final readonly class RunJobActionContractExpectation
{
    /**
     * @param Closure(Job, Command|null, string|null, self):void|null $_hook
     * @param Closure(Job, Command|null, string|null, self):void|null $_preHook
     */
    public function __construct(
        public mixed $return,
        public Job $job,
        public ?Command $command = null,
        public ?string $method = null,
        public ?Closure $_hook = null,
        public ?Closure $_preHook = null,
    ) {
    }
}
