<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Str;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasCustomPrefixRoutes;
use LaraStrict\Contracts\HasCustomRoutes;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Contracts\HasVersionedApiRoutes;
use LaraStrict\Entities\AppServiceProviderEntity;
use LaraStrict\Entities\CustomRouteEntity;
use LogicException;
use Psr\Log\LoggerInterface;

class LoadProviderRoutesPipe implements AppServiceProviderPipeContract
{
    public function __construct(
        private readonly Container $container,
        private readonly LoggerInterface $logger,
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

        $routesLoaded = [
            $this->tryToLoadApiRoutes($appServiceProvider, $dir, $serviceName, $urlPrefix),
            $this->registerRoute($dir, 'web', $serviceName, $urlPrefix),
            $this->tryToLoadCustomRoutes($appServiceProvider, $dir, $serviceName, $urlPrefix),
        ];

        if (array_filter($routesLoaded) === []) {
            $this->logger->warning(sprintf('No routes have been loaded for <%s> service', $serviceName), [
                'dir' => $dir,
                'service' => $appServiceProvider->serviceProvider::class,
            ]);
        }
    }

    protected function loadApiRoute(string $dir, string $serviceName, string $urlPrefix, ?int $version = null): bool
    {
        $versionFileSuffix = $version === null ? '' : '_v' . $version;
        $versionRoutePrefix = $version === null ? '' : 'v' . $version . '/';

        return $this->registerRoute(
            $dir,
            'api' . $versionFileSuffix,
            $serviceName,
            sprintf('api/%s%s', $versionRoutePrefix, $urlPrefix),
            'api'
        );
    }

    protected function registerRoute(
        string $dir,
        string $fileSuffix,
        string $serviceName,
        string $urlPrefix,
        ?string $middleware = null
    ): bool {
        $path = $this->getRouteFilePath($dir, $serviceName, $fileSuffix);

        if (file_exists($path) === false) {
            return false;
        }

        $this->makeRoute()
            ->prefix($urlPrefix)
            ->middleware($middleware ?? $fileSuffix)
            ->group($path);

        return true;
    }

    protected function getRouteFilePath(string $dir, string $serviceName, string $fileSuffix): string
    {
        return $dir . sprintf('/Http/routes/%s_%s.php', $serviceName, $fileSuffix);
    }

    protected function tryToLoadCustomRoutes(
        AppServiceProviderEntity $appServiceProvider,
        string $dir,
        string $serviceName,
        string $urlPrefix,
    ): bool {
        if ($appServiceProvider->serviceProvider instanceof HasCustomRoutes === false) {
            return false;
        }

        $didLoadRoutes = false;

        foreach ($appServiceProvider->serviceProvider->getCustomRoutes() as $key => $value) {
            if (is_numeric($key)) {
                if (is_string($value) === false) {
                    throw new LogicException(
                        'Custom route with numeric key expects file suffix name (value as string)'
                    );
                }

                if ($this->registerRoute($dir, $value, $serviceName, $urlPrefix)) {
                    $didLoadRoutes = true;
                }
            } else {
                if (is_callable($value) === false) {
                    throw new LogicException(
                        'Custom route with file suffix name as key expects closure to build the route'
                    );
                }

                $routeEntity = new CustomRouteEntity(
                    path: $this->getRouteFilePath($dir, $serviceName, $key),
                    serviceName: $serviceName,
                    urlPrefix: $urlPrefix
                );

                $result = $value($routeEntity, $this->makeRoute());

                if ($result) {
                    $didLoadRoutes = true;
                }
            }
        }

        return $didLoadRoutes;
    }

    protected function tryToLoadApiRoutes(
        AppServiceProviderEntity $appServiceProvider,
        string $dir,
        string $serviceName,
        string $urlPrefix
    ): bool {
        // Force the user to use versioned api or un-versioned api routes
        if ($appServiceProvider->serviceProvider instanceof HasVersionedApiRoutes === false) {
            return $this->loadApiRoute($dir, $serviceName, $urlPrefix);
        }

        $didLoadRoutes = false;
        foreach ($appServiceProvider->serviceProvider->apiVersions() as $version) {
            if ($this->loadApiRoute($dir, $serviceName, $urlPrefix, $version)) {
                $didLoadRoutes = true;
            }
        }

        return $didLoadRoutes;
    }

    protected function makeRoute(): RouteRegistrar
    {
        return $this->container->make(RouteRegistrar::class);
    }

    private function getUrlPrefix(string $serviceName, AppServiceProviderEntity $appServiceProvider): string
    {
        $prefix = str_replace('_', '-', Str::plural($serviceName));
        return $appServiceProvider->serviceProvider instanceof HasCustomPrefixRoutes
            ? $appServiceProvider->serviceProvider->getRoutePrefix($prefix)
            : $prefix;
    }
}
