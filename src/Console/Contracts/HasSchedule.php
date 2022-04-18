<?php

declare(strict_types=1);

namespace LaraStrict\Console\Contracts;

interface HasSchedule
{
    public function schedule(ScheduleServiceContract $schedule): void;
}
