<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderRoutesPipe\WithCustom;

use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Contracts\RegisterNamedCustomRouteActionContract;
use LaraStrict\Providers\Entities\CustomRouteEntity;

class RegisterNamedCustomRouteAction implements RegisterNamedCustomRouteActionContract
{
    public function getFileSuffix(): string
    {
        return 'custom_route';
    }

    public function execute(CustomRouteEntity $customRoute, RouteRegistrar $routeRegistrar): bool
    {
        $routeRegistrar
            ->prefix('custom-route-2/' . $customRoute->urlPrefix)
            ->group($customRoute->path);

        return true;
    }
}
