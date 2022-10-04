<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

class PreventLazyLoadingPipe implements AppServiceProviderPipeContract
{
    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        // TODO CONFIG
        //Model::preventLazyLoading(true);

        $next($appServiceProvider);
    }
}
