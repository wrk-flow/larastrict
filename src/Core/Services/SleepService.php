<?php

declare(strict_types=1);

namespace LaraStrict\Core\Services;

use LaraStrict\Core\Contracts\SleepServiceContract;

final class SleepService implements SleepServiceContract
{
    public function sleep(int $milliSeconds): void
    {
        usleep($milliSeconds * 1000);
    }

    public function sleepRandom(int $fromMilliSeconds, int $toMilliSeconds): void
    {
        $this->sleep(random_int($fromMilliSeconds, $toMilliSeconds));
    }
}
