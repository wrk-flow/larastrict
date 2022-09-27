<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderRoutesPipe;

use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Providers\AbstractServiceProvider;

class RoutableWithNoFilesServiceProvider extends AbstractServiceProvider implements HasRoutes
{
}
