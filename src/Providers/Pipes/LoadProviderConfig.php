<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Providers\Contracts\HasConfig;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

class LoadProviderConfig implements AppServiceProviderPipeContract
{
    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        if ($appServiceProvider->serviceProvider instanceof HasConfig) {
            $appServiceProvider->serviceProvider->laraLoadProviderConfigFrom(
                path: $appServiceProvider->serviceRootDir,
                namespace: $appServiceProvider->serviceFileName
            );
        }

        $next($appServiceProvider);
    }
}
