<?php

declare(strict_types=1);

namespace LaraStrict\Context;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Context\Contracts\ContextServiceContract;
use LaraStrict\Context\Services\ContextEventsService;
use LaraStrict\Context\Services\ContextService;

class ContextServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        // Make the service context singleton - if we are using heavy dependency injection it will slow down
        // resolving if not singleton
        $this->app->singleton(ContextEventsService::class, ContextEventsService::class);
        $this->app->singleton(ContextServiceContract::class, ContextService::class);
    }
}
