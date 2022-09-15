<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\WithCustom;

use Illuminate\Routing\RouteRegistrar;
use LaraStrict\Contracts\HasCustomRoutes;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Entities\CustomRouteEntity;
use LaraStrict\Providers\AbstractServiceProvider;

class WithCustomServiceProvider extends AbstractServiceProvider implements HasRoutes, HasCustomRoutes
{
    public function getCustomRoutes(): array
    {
        return [
            'admin',
            'dev' => static function (CustomRouteEntity $entity, RouteRegistrar $router): bool {
                $router
                    ->prefix('dev/' . $entity->urlPrefix)
                    ->group($entity->path);
                return true;
            },
            'testing' => static fn (): bool => false,
        ];
    }
}
