<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Str;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Entities\AppServiceProviderEntity;

class LoadRoutesProviderPipe implements AppServiceProviderPipeContract
{
    public function __construct(
        private readonly RouteRegistrar $router
    ) {
    }

    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        if (($appServiceProvider->application instanceof CachesRoutes &&
                $appServiceProvider->application->routesAreCached()) === false) {
            if ($appServiceProvider->serviceProvider instanceof HasRoutes === false) {
                return;
            }

            $dir = $appServiceProvider->serviceRootDir;
            $serviceName = $appServiceProvider->serviceName;

            $urlPrefix = Str::plural($serviceName);

            $api = $dir . sprintf('/Http/routes/%s_api.php', $serviceName);

            if (file_exists($api)) {
                $this->router
                    ->prefix(sprintf('api/%s', $urlPrefix))
                    ->middleware('api')
                    ->group($api);
            }

            $web = $dir . sprintf('/Http/routes/%s_web.php', $serviceName);

            if (file_exists($web)) {
                $this->router
                    ->prefix($urlPrefix)
                    ->middleware('web')
                    ->group($web);
            }
        }

        $next($appServiceProvider);
    }
}
