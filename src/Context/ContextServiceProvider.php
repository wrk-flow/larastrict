<?php

declare(strict_types=1);

namespace LaraStrict\Context;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Context\Services\ContextEventsService;

class ContextServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        // Make the service context singleton - if we are using heavy dependency injection it will slow down
        // resolving if not singleton
        $this->app->singleton(ContextEventsService::class, ContextEventsService::class);
    }
}
