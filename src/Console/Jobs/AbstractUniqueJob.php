<?php

declare(strict_types=1);

namespace LaraStrict\Console\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use LaraStrict\Queue\Jobs\Job;

abstract class AbstractUniqueJob extends Job implements ShouldBeUnique
{
    public int $tries = 30;

    public int $uniqueFor = 10;

    public int $maxExceptions = 1;

    abstract public function uniqueId(): string;

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [5, 10, 5];
    }
}
