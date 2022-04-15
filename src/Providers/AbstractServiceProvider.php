<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Enums\EnvironmentTypes;
use LaraStrict\Providers\Contracts\HasSchedule;
use LaraStrict\Providers\Contracts\HasScheduleOnProduction;

abstract class AbstractServiceProvider extends EventServiceProvider
{
    public function register(): void
    {
        parent::register();

        if ($this->app->runningInConsole() === true && $this->canRegisterSchedule()) {
            $this->app->booted(function (): void {
                $schedule = $this->app->make(ScheduleServiceContract::class);

                $this->schedule($schedule);
            });
        }
    }

    protected function canRegisterSchedule(): bool
    {
        if ($this instanceof HasScheduleOnProduction) {
            return $this->app->environment([EnvironmentTypes::Production->value]);
        }

        return $this instanceof HasSchedule;
    }
}
