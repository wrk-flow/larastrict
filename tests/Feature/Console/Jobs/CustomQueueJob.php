<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Console\Jobs;

use LaraStrict\Console\Jobs\AbstractUniqueJob;

class CustomQueueJob extends AbstractUniqueJob
{
    public $queue = 'custom';

    public function uniqueId(): string
    {
        return 'test';
    }
}
