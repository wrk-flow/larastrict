<?php

declare(strict_types=1);

namespace LaraStrict\Console\Jobs;

/**
 * There are jobs that are schedule very offten and can take some time. We need to setup correct conditions.
 */
abstract class AbstractUniqueLongJob extends AbstractUniqueJob
{
    public int $tries = 60;

    public int $maxExceptions = 1;

    public int $uniqueFor = 300;

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [1, 10, 30, 20];
    }
}
