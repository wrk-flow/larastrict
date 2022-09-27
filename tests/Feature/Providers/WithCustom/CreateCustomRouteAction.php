<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\WithCustom;

use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Contracts\CreateCustomRouteActionContract;
use LaraStrict\Entities\CustomRouteEntity;

class CreateCustomRouteAction implements CreateCustomRouteActionContract
{
    public function execute(CustomRouteEntity $customRoute, RouteRegistrar $routeRegistrar): bool
    {
        $routeRegistrar
            ->prefix('custom-route/' . $customRoute->urlPrefix)
            ->group($customRoute->path);

        return true;
    }
}
