<?php

declare(strict_types=1);

namespace Larastrict\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Larastrict\Console\Contracts\ScheduleServiceContract;

abstract class AbstractServiceProvider extends EventServiceProvider
{
    public function register(): void
    {
        parent::register();

        if ($this->app->runningInConsole() === true) {
            $this->app->booted(function (): void {
                $schedule = $this->app->make(ScheduleServiceContract::class);

                $this->schedule($schedule);
            });
        }
    }

    public function schedule(ScheduleServiceContract $schedule): void
    {
    }
}
