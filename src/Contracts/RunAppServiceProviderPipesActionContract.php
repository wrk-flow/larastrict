<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

use LaraStrict\Entities\AppServiceProviderEntity;

interface RunAppServiceProviderPipesActionContract
{
    /**
     * @param array<class-string<AppServiceProviderPipeContract>> $pipes
     */
    public function execute(AppServiceProviderEntity $appServiceProvider, array $pipes): void;
}
