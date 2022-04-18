<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use LaraStrict\Console\Contracts\HasSchedule;
use LaraStrict\Console\Contracts\HasScheduleOnProduction;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Enums\EnvironmentTypes;

abstract class AbstractServiceProvider extends EventServiceProvider
{
    public function register(): void
    {
        parent::register();

        if ($this->app->runningInConsole() && $this->canRegisterSchedule()) {
            $this->app->booted(function (): void {
                $schedule = $this->app->make(ScheduleServiceContract::class);

                /** @var HasSchedule $this */
                $this->schedule($schedule);
            });
        }
    }

    protected function canRegisterSchedule(): bool
    {
        if ($this instanceof HasScheduleOnProduction) {
            return (bool) $this->app->environment([EnvironmentTypes::Production->value]);
        }

        return $this instanceof HasSchedule;
    }
}
