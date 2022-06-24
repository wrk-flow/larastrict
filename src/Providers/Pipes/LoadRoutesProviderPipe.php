<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Str;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasCustomPrefixRoutes;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Contracts\HasVersionedApiRoutes;
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

            $this->loadRoutes($appServiceProvider);
        }

        $next($appServiceProvider);
    }

    protected function loadRoutes(AppServiceProviderEntity $appServiceProvider): void
    {
        $dir = $appServiceProvider->serviceRootDir;
        $serviceName = $appServiceProvider->serviceName;

        $urlPrefix = $this->getUrlPrefix($serviceName, $appServiceProvider);

        // Force the user to use versioned api or un-versioned api routes
        if ($appServiceProvider->serviceProvider instanceof HasVersionedApiRoutes) {
            foreach ($appServiceProvider->serviceProvider->apiVersions() as $version) {
                $this->loadApiRoute($dir, $serviceName, $urlPrefix, $version);
            }
        } else {
            $this->loadApiRoute($dir, $serviceName, $urlPrefix);
        }

        $web = $dir . sprintf('/Http/routes/%s_web.php', $serviceName);

        if (file_exists($web)) {
            $this->router
                ->prefix($urlPrefix)
                ->middleware('web')
                ->group($web);
        }
    }

    protected function loadApiRoute(string $dir, string $serviceName, string $urlPrefix, ?int $version = null): void
    {
        $versionFileSuffix = $version === null ? '' : '_v' . $version;
        $versionRoutePrefix = $version === null ? '' : 'v' . $version . '/';

        $api = $dir . sprintf('/Http/routes/%s_api%s.php', $serviceName, $versionFileSuffix);

        if (file_exists($api)) {
            $this->router
                ->prefix(sprintf('api/%s%s', $versionRoutePrefix, $urlPrefix))
                ->middleware('api')
                ->group($api);
        }
    }

    private function getUrlPrefix(string $serviceName, AppServiceProviderEntity $appServiceProvider): string
    {
        $prefix = Str::plural($serviceName);
        return $appServiceProvider->serviceProvider instanceof HasCustomPrefixRoutes
            ? $appServiceProvider->serviceProvider->getRoutePrefix($prefix)
            : $prefix;
    }
}
