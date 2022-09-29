<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Actions\BootLaraStrictAction;
use LaraStrict\Actions\RunAppServiceProviderPipesAction;
use LaraStrict\Cache\CacheServiceProvider;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Console\Services\ScheduleServiceService;
use LaraStrict\Context\ContextServiceProvider;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Database\DatabaseServiceProvider;
use LaraStrict\Testing\TestServiceProvider;

class LaraStrictServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        // Add ability to "switch" the implementation - it is important to run it now.
        $this->app->singleton(ScheduleServiceContract::class, ScheduleServiceContract::class);
        $this->app->alias(ScheduleServiceService::class, ScheduleServiceContract::class);

        $this->app->bind(RunAppServiceProviderPipesActionContract::class, RunAppServiceProviderPipesAction::class);

        // Register our service providers
        $this->app->register(ContextServiceProvider::class);
        $this->app->register(CacheServiceProvider::class);
        $this->app->register(DatabaseServiceProvider::class);
        $this->app->register(TestServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /** @var BootLaraStrictAction $boot */
        $boot = $this->app->make(BootLaraStrictAction::class);

        $boot->execute($this->app, $this);
    }
}
