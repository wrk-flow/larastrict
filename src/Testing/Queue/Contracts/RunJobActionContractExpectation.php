<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Jobs\Job;

final class RunJobActionContractExpectation
{
    /**
     * @param Closure(Job, Command, string, self):void|null $_hook
     */
    public function __construct(
        public readonly mixed $return,
        public readonly Job $job,
        public readonly ?Command $command = null,
        public readonly ?string $method = null,
        public readonly ?Closure $_hook = null,
    ) {
    }
}
