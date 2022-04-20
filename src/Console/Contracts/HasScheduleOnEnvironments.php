<?php

declare(strict_types=1);

namespace LaraStrict\Console\Contracts;

interface HasScheduleOnEnvironments extends HasSchedule
{
    /**
     * @return array<string>
     */
    public function scheduleEnvironments(): array;
}
