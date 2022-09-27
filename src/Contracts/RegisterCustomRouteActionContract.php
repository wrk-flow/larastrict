<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Entities\CustomRouteEntity;

interface RegisterCustomRouteActionContract
{
    /**
     * Registers custom route. Returns false if no registration has been made.
     */
    public function execute(CustomRouteEntity $customRoute, RouteRegistrar $routeRegistrar): bool;
}
