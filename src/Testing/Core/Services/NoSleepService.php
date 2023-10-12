<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Core\Services;

use LaraStrict\Core\Contracts\SleepServiceContract;

final class NoSleepService implements SleepServiceContract
{
    public function sleep(int $milliSeconds): void
    {
    }

    public function sleepRandom(int $fromMilliSeconds, int $toMilliSeconds): void
    {
    }
}
