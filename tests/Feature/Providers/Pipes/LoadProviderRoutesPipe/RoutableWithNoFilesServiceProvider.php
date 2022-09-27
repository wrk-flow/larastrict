<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderRoutesPipe;

use LaraStrict\Contracts\HasCustomRoutes;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Providers\AbstractServiceProvider;

class RoutableWithNoFilesServiceProvider extends AbstractServiceProvider implements HasRoutes, HasCustomRoutes
{
    public function getCustomRoutes(): array
    {
        return [
            'testing' => static fn (): bool => false,
            NoNamedCustomRouteAction::class,
            'class' => NoCustomRouteAction::class,
        ];
    }
}
