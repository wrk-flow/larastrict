<?php

declare(strict_types=1);

namespace LaraStrict\Health;

use LaraStrict\Contracts\HasCustomPrefixRoutes;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Providers\AbstractServiceProvider;

class HealthServiceProvider extends AbstractServiceProvider implements HasRoutes, HasCustomPrefixRoutes
{
    public function getRoutePrefix(string $generatedPrefix): string
    {
        return 'health';
    }
}
