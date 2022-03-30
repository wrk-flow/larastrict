<?php

declare(strict_types=1);

namespace Larastrict\Console\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;

abstract class AbstractUniqueJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;
    use InteractsWithQueue;

    public int $tries = 30;
    public int $uniqueFor = 10;
    public int $maxExceptions = 1;

    public function __construct()
    {
        $this->queue = 'default';
    }

    abstract public function uniqueId(): string;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [
            (new WithoutOverlapping($this->uniqueId()))->expireAfter($this->uniqueFor),
        ];
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [5, 10, 5];
    }
}
