<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Pipes\LoadProviderConfig\Invalid;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Providers\Contracts\HasConfig;

class InvalidConfigServiceProvider extends ServiceProvider implements HasConfig
{
}
