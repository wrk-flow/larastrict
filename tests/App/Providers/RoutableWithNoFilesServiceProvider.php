<?php

declare(strict_types=1);

namespace Tests\LaraStrict\App\Providers;

use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Providers\AbstractServiceProvider;

class RoutableWithNoFilesServiceProvider extends AbstractServiceProvider implements HasRoutes
{
}
