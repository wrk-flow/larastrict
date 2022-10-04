<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

use Illuminate\Contracts\Foundation\Application;
use LaraStrict\Providers\AbstractBaseServiceProvider;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;

interface CreateAppServiceProviderActionContract
{
    public function execute(Application $application, AbstractBaseServiceProvider $provider): AppServiceProviderEntity;
}
