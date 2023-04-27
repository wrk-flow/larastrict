<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderConfig\NoConfig;

use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Contracts\HasConfig;

class NoConfigServiceProvider extends AbstractServiceProvider implements HasConfig
{
}
