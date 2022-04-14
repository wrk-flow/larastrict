<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Providers\Contracts\HasSchedule;

abstract class AbstractServiceProvider extends EventServiceProvider
{
    public function register(): void
    {
        parent::register();

        if ($this instanceof HasSchedule && $this->app->runningInConsole() === true) {
            $this->app->booted(function (): void {
                $schedule = $this->app->make(ScheduleServiceContract::class);

                $this->schedule($schedule);
            });
        }
    }
}
