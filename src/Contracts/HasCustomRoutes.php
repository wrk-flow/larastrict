<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

use Closure;
use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Entities\CustomRouteEntity;

interface HasCustomRoutes
{
    /**
     * @return array<string|int, Closure(CustomRouteEntity,RouteRegistrar):bool|string>
     */
    public function getCustomRoutes(): array;
}
