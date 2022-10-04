<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderRoutesPipe;

use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Contracts\RegisterCustomRouteActionContract;
use LaraStrict\Providers\Entities\CustomRouteEntity;

class NoCustomRouteAction implements RegisterCustomRouteActionContract
{
    public function execute(CustomRouteEntity $customRoute, RouteRegistrar $routeRegistrar): bool
    {
        return false;
    }
}
