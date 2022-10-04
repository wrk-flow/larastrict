<?php

declare(strict_types=1);

namespace LaraStrict\Core\Actions;

use Illuminate\Contracts\Foundation\Application;
use LaraStrict\Contracts\CreateAppServiceProviderActionContract;
use LaraStrict\Providers\AbstractBaseServiceProvider;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

class CreateCoreAppServiceProviderAction implements CreateAppServiceProviderActionContract
{
    public function execute(Application $application, AbstractBaseServiceProvider $provider): AppServiceProviderEntity
    {
        return new AppServiceProviderEntity(
            application: $application,
            serviceProvider: $provider,
            serviceName: 'LaraStrict',
            serviceFileName: 'lara_strict',
            serviceRootDir: 'src/Core',
            namespace: 'LaraStrict\\Core'
        );
    }
}
