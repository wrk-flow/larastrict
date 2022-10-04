<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasViews;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

class LoadProviderViews implements AppServiceProviderPipeContract
{
    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        if ($appServiceProvider->serviceProvider instanceof HasViews) {
            $appServiceProvider->serviceProvider->laraLoadViewsFrom(
                $appServiceProvider->serviceRootDir . '/Views',
                $appServiceProvider->serviceName
            );
        }

        $next($appServiceProvider);
    }
}
