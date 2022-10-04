<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Str;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasCustomPrefixRoutes;
use LaraStrict\Contracts\HasCustomRoutes;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Contracts\HasVersionedApiRoutes;
use LaraStrict\Contracts\RegisterCustomRouteActionContract;
use LaraStrict\Contracts\RegisterNamedCustomRouteActionContract;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;
use LaraStrict\Providers\Entities\CustomRouteEntity;
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
                $next($appServiceProvider);
                return;
            }

            $this->loadRoutes($appServiceProvider);
        }

        $next($appServiceProvider);
    }

    protected function loadRoutes(AppServiceProviderEntity $appServiceProvider): void
    {
        $dir = $appServiceProvider->serviceRootDir;
        $serviceFileName = $appServiceProvider->serviceFileName;

        $urlPrefix = $this->getUrlPrefix($serviceFileName, $appServiceProvider);

        $routesLoaded = [
            $this->tryToLoadApiRoutes($appServiceProvider, $dir, $serviceFileName, $urlPrefix),
            $this->registerRoute($dir, 'web', $serviceFileName, $urlPrefix),
            $this->tryToLoadCustomRoutes($appServiceProvider, $dir, $serviceFileName, $urlPrefix),
        ];

        if (array_filter($routesLoaded) === []) {
            $this->logger->warning(sprintf('No routes have been loaded for <%s> service', $serviceFileName), [
                'dir' => $dir,
                'service' => $appServiceProvider->serviceProvider::class,
            ]);
        }
    }

    protected function loadApiRoute(string $dir, string $serviceFileName, string $urlPrefix, ?int $version = null): bool
    {
        $versionFileSuffix = $version === null ? '' : '_v' . $version;
        $versionRoutePrefix = $version === null ? '' : 'v' . $version . '/';

        return $this->registerRoute(
            $dir,
            'api' . $versionFileSuffix,
            $serviceFileName,
            sprintf('api/%s%s', $versionRoutePrefix, $urlPrefix),
            'api'
        );
    }

    protected function registerRoute(
        string $dir,
        string $fileSuffix,
        string $serviceFileName,
        string $urlPrefix,
        ?string $middleware = null
    ): bool {
        $path = $this->getRouteFilePath($dir, $serviceFileName, $fileSuffix);

        if (file_exists($path) === false) {
            return false;
        }

        $this->makeRoute()
            ->prefix($urlPrefix)
            ->middleware($middleware ?? $fileSuffix)
            ->group($path);

        return true;
    }

    protected function getRouteFilePath(string $dir, string $serviceFileName, string $fileSuffix): string
    {
        return $dir . sprintf('/Http/routes/%s_%s.php', $serviceFileName, $fileSuffix);
    }

    protected function tryToLoadCustomRoutes(
        AppServiceProviderEntity $appServiceProvider,
        string $dir,
        string $serviceFileName,
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

                if (class_exists($value)) {
                    $class = $this->container->make($value);
                    if ($class instanceof RegisterNamedCustomRouteActionContract === false) {
                        throw new LogicException(
                            'To build custom route with class you need to implement ' . RegisterNamedCustomRouteActionContract::class
                        );
                    }

                    $routeEntity = new CustomRouteEntity(
                        path: $this->getRouteFilePath($dir, $serviceFileName, $class->getFileSuffix()),
                        serviceName: $serviceFileName,
                        urlPrefix: $urlPrefix
                    );

                    if ($class->execute($routeEntity, $this->makeRoute())) {
                        $didLoadRoutes = true;
                    }
                } elseif ($this->registerRoute($dir, $value, $serviceFileName, $urlPrefix)) {
                    $didLoadRoutes = true;
                }

                continue;
            }

            $routeEntity = new CustomRouteEntity(
                path: $this->getRouteFilePath($dir, $serviceFileName, $key),
                serviceName: $serviceFileName,
                urlPrefix: $urlPrefix
            );

            if (is_callable($value)) {
                $result = $value($routeEntity, $this->makeRoute());
            } elseif (is_string($value) && class_exists($value)) {
                $class = $this->container->make($value);
                if ($class instanceof RegisterCustomRouteActionContract === false) {
                    throw new LogicException(
                        'To build custom route with class you need to implement ' . RegisterCustomRouteActionContract::class
                    );
                }

                $result = $class->execute($routeEntity, $this->makeRoute());
            } else {
                throw new LogicException(
                    'To build the custom route with file suffix name as key expects closure or class that implements ' . RegisterCustomRouteActionContract::class
                );
            }

            if ($result) {
                $didLoadRoutes = true;
            }
        }

        return $didLoadRoutes;
    }

    protected function tryToLoadApiRoutes(
        AppServiceProviderEntity $appServiceProvider,
        string $dir,
        string $serviceFileName,
        string $urlPrefix
    ): bool {
        // Force the user to use versioned api or un-versioned api routes
        if ($appServiceProvider->serviceProvider instanceof HasVersionedApiRoutes === false) {
            return $this->loadApiRoute($dir, $serviceFileName, $urlPrefix);
        }

        $didLoadRoutes = false;
        foreach ($appServiceProvider->serviceProvider->apiVersions() as $version) {
            if ($this->loadApiRoute($dir, $serviceFileName, $urlPrefix, $version)) {
                $didLoadRoutes = true;
            }
        }

        return $didLoadRoutes;
    }

    protected function makeRoute(): RouteRegistrar
    {
        return $this->container->make(RouteRegistrar::class);
    }

    private function getUrlPrefix(string $serviceFileName, AppServiceProviderEntity $appServiceProvider): string
    {
        $prefix = str_replace('_', '-', Str::plural($serviceFileName));
        return $appServiceProvider->serviceProvider instanceof HasCustomPrefixRoutes
            ? $appServiceProvider->serviceProvider->getRoutePrefix($prefix)
            : $prefix;
    }
}
