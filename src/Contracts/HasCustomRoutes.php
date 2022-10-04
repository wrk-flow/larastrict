<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

use Closure;
use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Providers\Entities\CustomRouteEntity;

interface HasCustomRoutes
{
    /**
     * @return array<string|int, class-string<RegisterCustomRouteActionContract>|string|Closure(CustomRouteEntity,RouteRegistrar):bool>
     */
    public function getCustomRoutes(): array;
}
