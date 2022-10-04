<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Entities;

use Illuminate\Contracts\Foundation\Application;
use LaraStrict\Providers\AbstractBaseServiceProvider;

class AppServiceProviderEntity
{
    public function __construct(
        public readonly Application $application,
        public readonly AbstractBaseServiceProvider $serviceProvider,
        public readonly string $serviceName,
        public readonly string $serviceFileName,
        public readonly string $serviceRootDir,
        public readonly string $namespace,
    ) {
    }
}
