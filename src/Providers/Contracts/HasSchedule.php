<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Contracts;

use LaraStrict\Console\Contracts\ScheduleServiceContract;

interface HasSchedule
{
    public function schedule(ScheduleServiceContract $schedule): void;
}
