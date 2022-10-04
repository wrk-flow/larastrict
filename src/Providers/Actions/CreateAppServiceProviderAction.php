<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Actions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use LaraStrict\Contracts\CreateAppServiceProviderActionContract;
use LaraStrict\Contracts\HasCustomServiceFileName;
use LaraStrict\Providers\AbstractBaseServiceProvider;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;
use LogicException;
use ReflectionClass;

class CreateAppServiceProviderAction implements CreateAppServiceProviderActionContract
{
    public function execute(Application $application, AbstractBaseServiceProvider $provider): AppServiceProviderEntity
    {
        // TODO cache
        $reflection = new ReflectionClass($provider);

        $dir = $this->getRootDirectory($reflection);
        $namespace = $reflection->getNamespaceName();
        $serviceNameParts = explode('\\', $namespace);
        $serviceName = end($serviceNameParts);

        return new AppServiceProviderEntity(
            application: $application,
            serviceProvider: $provider,
            serviceName: $serviceName,
            serviceFileName: $this->getServiceFileName($serviceName, $provider),
            serviceRootDir: $dir,
            namespace: $namespace
        );
    }

    /**
     * @param ReflectionClass<ServiceProvider> $reflection
     */
    protected function getRootDirectory(ReflectionClass $reflection): string
    {
        $fileName = $reflection->getFileName();
        if ($fileName === false) {
            throw new LogicException('Failed to get file name for service provider');
        }

        return dirname($fileName);
    }

    protected function getServiceFileName(string $serviceName, ServiceProvider $provider): string
    {
        if ($provider instanceof HasCustomServiceFileName) {
            return $provider->getServiceFileName();
        }

        return Str::snake($serviceName);
    }
}
