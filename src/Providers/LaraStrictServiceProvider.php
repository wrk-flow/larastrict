<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Cache\CacheServiceProvider;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Console\Services\ScheduleServiceService;
use LaraStrict\Context\ContextServiceProvider;

class LaraStrictServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->register(ContextServiceProvider::class);
        $this->app->register(CacheServiceProvider::class);

        // Add ability to "switch" the implementation.
        $this->app->singleton(ScheduleServiceContract::class, ScheduleServiceContract::class);
        $this->app->alias(ScheduleServiceService::class, ScheduleServiceContract::class);
    }
}
