<?php

declare(strict_types=1);

namespace LaraStrict\Testing;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Config\Laravel\AppConfig;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Testing\Actions\GetBasePathForStubsAction;
use LaraStrict\Testing\Actions\GetNamespaceForStubsAction;
use LaraStrict\Testing\Commands\MakeExpectationCommand;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;

class TestServiceProvider extends ServiceProvider
{
    public array $bindings = [
        GetBasePathForStubsActionContract::class => GetBasePathForStubsAction::class,
        GetNamespaceForStubsActionContract::class => GetNamespaceForStubsAction::class,
    ];

    public function register(): void
    {
        parent::register();

        if ($this->app->runningInConsole() === false) {
            return;
        }

        /** @var AppConfig $config */
        $config = $this->app->make(AppConfig::class);

        $environment = $config->getEnvironment();
        if (in_array($environment, [EnvironmentType::Testing, EnvironmentType::Local], false) === false) {
            return;
        }

        $this->commands([MakeExpectationCommand::class]);
    }
}
