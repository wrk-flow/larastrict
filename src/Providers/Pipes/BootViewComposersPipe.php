<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use Illuminate\Contracts\View\Factory;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasViewComposers;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

class BootViewComposersPipe implements AppServiceProviderPipeContract
{
    public function __construct(
        private readonly Factory $viewFactory,
    ) {
    }

    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        // We need to load view components to its own namespace because Views/components
        // requires lowercase components string (not compatible).
        if ($appServiceProvider->serviceProvider instanceof HasViewComposers) {
            $appServiceProvider->serviceProvider->bootViewComposers(
                serviceName: $appServiceProvider->serviceName,
                viewFactory: $this->viewFactory,
            );
        }

        $next($appServiceProvider);
    }
}
