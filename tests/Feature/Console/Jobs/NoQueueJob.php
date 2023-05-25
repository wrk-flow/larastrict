<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Console\Jobs;

use LaraStrict\Console\Jobs\AbstractUniqueJob;

class NoQueueJob extends AbstractUniqueJob
{
    public function uniqueId(): string
    {
        return 'test';
    }
}
