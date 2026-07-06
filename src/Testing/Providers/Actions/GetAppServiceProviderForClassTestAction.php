<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Providers\Actions;

use LaraStrict\Providers\Contracts\GetAppServiceProviderForClassActionContract;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;
use LaraStrict\Testing\Laravel\TestingApplication;
use LaraStrict\Testing\Providers\TestingLaraStrictServiceProvider;

final class GetAppServiceProviderForClassTestAction implements GetAppServiceProviderForClassActionContract
{
    public function execute(string $providerClass): AppServiceProviderEntity
    {
        $app = new TestingApplication();
        return new AppServiceProviderEntity(
            application: $app,
            serviceProvider: new TestingLaraStrictServiceProvider($app),
            serviceName: 'Test',
            serviceFileName: 'test',
            serviceRootDir: 'test',
            namespace: 'Test',
        );
    }
}
