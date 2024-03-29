<?php

declare(strict_types=1);

namespace LaraStrict\Core;

use LaraStrict\Cache\CacheServiceProvider;
use LaraStrict\Config\ConfigServiceProvider;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Console\Services\ScheduleService;
use LaraStrict\Context\ContextServiceProvider;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Core\Actions\CreateCoreAppServiceProviderAction;
use LaraStrict\Core\Contracts\SleepServiceContract;
use LaraStrict\Core\Services\ImplementsService;
use LaraStrict\Core\Services\SleepService;
use LaraStrict\Database\DatabaseServiceProvider;
use LaraStrict\Docker\DockerServiceProvider;
use LaraStrict\Log\LogServiceProvider;
use LaraStrict\Providers\AbstractBaseServiceProvider;
use LaraStrict\Providers\Actions\RunAppServiceProviderPipesAction;
use LaraStrict\Providers\Pipes\PreventLazyLoadingPipe;
use LaraStrict\Providers\Pipes\SetFactoryResolvingProviderPipe;
use LaraStrict\Queue\QueueServiceProvider;
use LaraStrict\Testing\TestServiceProvider;

class LaraStrictServiceProvider extends AbstractBaseServiceProvider
{
    public function register(): void
    {
        // Add ability to "switch" the implementation - it is important to run it now.
        $this->app->singleton(SleepServiceContract::class, SleepService::class);
        $this->app->singleton(ScheduleServiceContract::class, ScheduleServiceContract::class);
        $this->app->alias(ScheduleService::class, ScheduleServiceContract::class);

        $this->app->bind(RunAppServiceProviderPipesActionContract::class, RunAppServiceProviderPipesAction::class);

        // Register our service providers
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(ContextServiceProvider::class);
        $this->app->register(CacheServiceProvider::class);
        $this->app->register(DatabaseServiceProvider::class);
        $this->app->register(TestServiceProvider::class);
        $this->app->register(DockerServiceProvider::class);
        $this->app->register(LogServiceProvider::class);
        $this->app->register(QueueServiceProvider::class);

        $this->app->singleton(ImplementsService::class, ImplementsService::class);

        parent::register();
    }

    protected function registerPipes(): array
    {
        return [];
    }

    protected function bootPipes(): array
    {
        return [PreventLazyLoadingPipe::class, SetFactoryResolvingProviderPipe::class];
    }

    protected function getCreateAppServiceProviderActionClass(): string
    {
        return CreateCoreAppServiceProviderAction::class;
    }
}
