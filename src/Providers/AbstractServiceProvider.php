<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use LaraStrict\Cache\Contracts\BootContexts;
use LaraStrict\Console\Contracts\HasSchedule;
use LaraStrict\Console\Contracts\HasScheduleOnEnvironments;
use LaraStrict\Console\Contracts\HasScheduleOnProduction;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Services\ContextEventsService;
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

    public function boot(): void
    {
        if ($this instanceof BootContexts) {
            $this->bootContexts($this->contexts());
        }
    }

    protected function canRegisterSchedule(): bool
    {
        if ($this instanceof HasScheduleOnEnvironments) {
            return (bool) $this->app->environment($this->scheduleEnvironments());
        }

        if ($this instanceof HasScheduleOnProduction) {
            return (bool) $this->app->environment([EnvironmentTypes::Production->value]);
        }

        return $this instanceof HasSchedule;
    }

    /**
     * @param array<class-string<AbstractContext>> $contextClasses
     */
    private function bootContexts(array $contextClasses): void
    {
        if ($contextClasses === []) {
            return;
        }

        /** @var ContextEventsService $service */
        $service = $this->app->make(ContextEventsService::class);

        foreach ($contextClasses as $context) {
            $context::boot($service);
        }
    }
}
