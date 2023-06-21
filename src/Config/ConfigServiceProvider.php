<?php

declare(strict_types=1);

namespace LaraStrict\Config;

use LaraStrict\Config\Contracts\AppConfigContract;
use LaraStrict\Config\Laravel\AppConfig;
use LaraStrict\Providers\AbstractServiceProvider;

class ConfigServiceProvider extends AbstractServiceProvider
{
    public array $bindings = [
        AppConfigContract::class => AppConfig::class,
    ];
}
