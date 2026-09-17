<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use Closure;
use LaraStrict\Queue\Jobs\Job;

final readonly class DispatchJobActionContractExpectation
{
    /**
     * @param Closure(Job, self):void|null $_hook
     */
    public function __construct(
        public bool $return,
        public Job $job,
        public ?Closure $_hook = null,
    ) {
    }
}
