<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderRoutesPipe\WithCustom;

use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Contracts\RegisterCustomRouteActionContract;
use LaraStrict\Providers\Entities\CustomRouteEntity;

class RegisterCustomRouteAction implements RegisterCustomRouteActionContract
{
    public function execute(CustomRouteEntity $customRoute, RouteRegistrar $routeRegistrar): bool
    {
        $routeRegistrar
            ->prefix('custom-route/' . $customRoute->urlPrefix)
            ->group($customRoute->path);

        return true;
    }
}
