<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderRoutesPipe;

use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Contracts\RegisterNamedCustomRouteActionContract;
use LaraStrict\Entities\CustomRouteEntity;

class NoNamedCustomRouteAction implements RegisterNamedCustomRouteActionContract
{
    public function execute(CustomRouteEntity $customRoute, RouteRegistrar $routeRegistrar): bool
    {
        return false;
    }

    public function getFileSuffix(): string
    {
        return 'test';
    }
}
