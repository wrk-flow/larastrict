<?php

declare(strict_types=1);

namespace LaraStrict\Entities;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProviderEntity
{
    public function __construct(
        public readonly Application $application,
        public readonly ServiceProvider $serviceProvider,
        public readonly string $serviceName,
        public readonly string $serviceRootDir,
    ) {
    }
}
