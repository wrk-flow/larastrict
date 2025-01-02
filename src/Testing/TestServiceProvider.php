<?php

declare(strict_types=1);

namespace LaraStrict\Testing;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Config\Contracts\AppConfigContract;
use LaraStrict\Core\Contracts\SleepServiceContract;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Testing\Actions\FindAllClassesAction;
use LaraStrict\Testing\Actions\GetBasePathForAssertsAction;
use LaraStrict\Testing\Actions\GetBasePathForStubsAction;
use LaraStrict\Testing\Actions\GetNamespaceForStubsAction;
use LaraStrict\Testing\Commands\MakeExpectationCommand;
use LaraStrict\Testing\Contracts\FindAllClassesActionContract;
use LaraStrict\Testing\Contracts\FinderFactoryContract;
use LaraStrict\Testing\Contracts\GetBasePathForAssertsActionContract;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use LaraStrict\Testing\Core\Services\NoSleepService;
use LaraStrict\Testing\Factories\FinderFactory;

class TestServiceProvider extends ServiceProvider
{
    public array $bindings = [
        GetBasePathForStubsActionContract::class => GetBasePathForStubsAction::class,
        GetBasePathForAssertsActionContract::class => GetBasePathForAssertsAction::class,
        GetNamespaceForStubsActionContract::class => GetNamespaceForStubsAction::class,
        FinderFactoryContract::class => FinderFactory::class,
        FindAllClassesActionContract::class => FindAllClassesAction::class,
    ];

    public function register(): void
    {
        parent::register();

        if ($this->app->runningInConsole() === false) {
            return;
        }

        /** @var AppConfigContract $config */
        $config = $this->app->make(AppConfigContract::class);

        $environment = $config->getEnvironment();
        if (in_array($environment, [EnvironmentType::Testing, EnvironmentType::Local], false) === false) {
            return;
        }

        $this->commands([MakeExpectationCommand::class]);

        if ($this->app->runningUnitTests()) {
            $this->app->singleton(SleepServiceContract::class, NoSleepService::class);
        }
    }
}
