<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

abstract class Job implements ShouldQueue
{
    use Queueable;
    use InteractsWithQueue;

    public function __construct()
    {
        // When queueing a job with schedule then the queue is not set by Laravel, this will
        // fix it.
        if ($this->queue === null) {
            $this->queue = 'default';
        }
    }
}
