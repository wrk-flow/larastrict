<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Config\Valid;

use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Contracts\HasConfig;

class ValidConfigServiceProvider extends AbstractServiceProvider implements HasConfig
{
}
