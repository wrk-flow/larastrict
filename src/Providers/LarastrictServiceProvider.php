<?php

declare(strict_types=1);

namespace Larastrict\Providers;

use Illuminate\Support\ServiceProvider;
use Larastrict\Console\Contracts\ScheduleServiceContract;
use Larastrict\Console\Services\ScheduleServiceService;

class LarastrictServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Add ability to "switch" the implementation.
        $this->app->singleton(ScheduleServiceContract::class, ScheduleServiceContract::class);
        $this->app->alias(ScheduleServiceService::class, ScheduleServiceContract::class);
    }
}
