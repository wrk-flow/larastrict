<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use Closure;
use LaraStrict\Queue\Jobs\Job;

final class DispatchJobActionContractExpectation
{
    /**
     * @param Closure(Job, self):void|null $_hook
     */
    public function __construct(
        public readonly bool $return,
        public readonly Job $job,
        public readonly ?Closure $_hook = null,
    ) {
    }
}
