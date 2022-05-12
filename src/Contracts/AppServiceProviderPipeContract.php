<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

use Closure;
use LaraStrict\Entities\AppServiceProviderEntity;

interface AppServiceProviderPipeContract
{
    /**
     * @param Closure(AppServiceProviderEntity):void $next
     */
    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void;
}
