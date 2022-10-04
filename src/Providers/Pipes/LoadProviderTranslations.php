<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasTranslations;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

class LoadProviderTranslations implements AppServiceProviderPipeContract
{
    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        if ($appServiceProvider->serviceProvider instanceof HasTranslations) {
            $appServiceProvider->serviceProvider->laraLoadTranslationsFrom(
                $appServiceProvider->serviceRootDir . '/Translations',
                $appServiceProvider->serviceName
            );
        }

        $next($appServiceProvider);
    }
}
