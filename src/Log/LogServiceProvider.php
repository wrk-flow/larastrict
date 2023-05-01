<?php

declare(strict_types=1);

namespace LaraStrict\Log;

use LaraStrict\Log\Managers\ConsoleOutputManager;
use LaraStrict\Providers\AbstractServiceProvider;

class LogServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton(ConsoleOutputManager::class);
    }

    public function boot(): void
    {
        parent::boot();

        /** @var ConsoleOutputManager $consoleOutputManager */
        $consoleOutputManager = $this->app->make(ConsoleOutputManager::class);
        $consoleOutputManager->boot();
    }
}
