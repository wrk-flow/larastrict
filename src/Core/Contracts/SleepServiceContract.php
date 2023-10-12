<?php

declare(strict_types=1);

namespace LaraStrict\Core\Contracts;

interface SleepServiceContract
{
    public function sleep(int $milliSeconds): void;

    public function sleepRandom(int $fromMilliSeconds, int $toMilliSeconds): void;
}
