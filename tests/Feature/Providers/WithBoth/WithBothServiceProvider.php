<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\WithBoth;

use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Providers\AbstractServiceProvider;

class WithBothServiceProvider extends AbstractServiceProvider implements HasRoutes
{
}
