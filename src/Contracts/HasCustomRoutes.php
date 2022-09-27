<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

use Closure;
use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Entities\CustomRouteEntity;

interface HasCustomRoutes
{
    /**
     * @return array<string|int, class-string<CreateCustomRouteActionContract>|string|Closure(CustomRouteEntity,RouteRegistrar):bool>
     */
    public function getCustomRoutes(): array;
}
