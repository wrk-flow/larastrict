<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Contracts;

use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

interface GetAppServiceProviderForClassActionContract
{
    /**
     * @param class-string<AbstractServiceProvider> $providerClass
     */
    public function execute(string $providerClass): AppServiceProviderEntity;
}
