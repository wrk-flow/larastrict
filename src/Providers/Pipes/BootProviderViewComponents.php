<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use Illuminate\View\Compilers\BladeCompiler;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasViewComponents;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

class BootProviderViewComponents implements AppServiceProviderPipeContract
{
    public function __construct(
        private readonly BladeCompiler $bladeCompiler
    ) {
    }

    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        // We need to load view components to its own namespace because Views/components
        // requires lowercase components string (not compatible).
        if ($appServiceProvider->serviceProvider instanceof HasViewComponents) {
            $namespace = $appServiceProvider->namespace . '\\Components';

            $this->bladeCompiler->componentNamespace($namespace, $appServiceProvider->serviceName);
        }

        $next($appServiceProvider);
    }
}
