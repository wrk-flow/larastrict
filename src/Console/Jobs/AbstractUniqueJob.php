<?php

declare(strict_types=1);

namespace LaraStrict\Console\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

abstract class AbstractUniqueJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;
    use InteractsWithQueue;

    public int $tries = 30;

    public int $uniqueFor = 10;

    public int $maxExceptions = 1;

    public function __construct()
    {
        if ($this->queue !== null) {
            $this->queue = 'default';
        }
    }

    abstract public function uniqueId(): string;

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [5, 10, 5];
    }
}
