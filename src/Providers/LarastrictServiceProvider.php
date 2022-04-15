<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Console\Services\ScheduleServiceService;

class LaraStrictServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        // Add ability to "switch" the implementation.
        $this->app->singleton(ScheduleServiceContract::class, ScheduleServiceContract::class);
        $this->app->alias(ScheduleServiceService::class, ScheduleServiceContract::class);
    }
}
