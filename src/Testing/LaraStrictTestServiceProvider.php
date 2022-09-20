<?php

declare(strict_types=1);

namespace LaraStrict\Testing;

use LaraStrict\Config\Laravel\AppConfig;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Testing\Commands\MakeExpectationCommand;

class LaraStrictTestServiceProvider extends AbstractServiceProvider
{
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
