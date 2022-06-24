<?php

declare(strict_types=1);

namespace LaraStrict\Actions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use LaraStrict\Contracts\HasCustomServiceName;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Entities\AppServiceProviderEntity;
use LaraStrict\Providers\Pipes\LoadRoutesProviderPipe;
use LogicException;
use ReflectionClass;

class BootServiceProviderAction
{
    public function __construct(
        private readonly RunAppServiceProviderPipesActionContract $runPipesAction
    ) {
    }

    public function execute(Application $application, ServiceProvider $provider): void
    {
        $reflection = new ReflectionClass($provider);

        $dir = $this->getRootDirectory($reflection);
        $serviceName = $this->getServiceName($reflection, $provider);
        $pipes = [LoadRoutesProviderPipe::class];

        $app = new AppServiceProviderEntity($application, $provider, $serviceName, $dir);

        $this->runPipesAction->execute($app, $pipes);
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

    /**
     * @param ReflectionClass<ServiceProvider> $reflection
     */
    protected function getServiceName(ReflectionClass $reflection, ServiceProvider $provider): string
    {
        if ($provider instanceof HasCustomServiceName) {
            return $provider->getServiceName();
        }

        $parts = explode('\\', $reflection->getNamespaceName());
        return Str::snake(end($parts));
    }
}
