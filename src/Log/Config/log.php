<?php

declare(strict_types=1);

use LaraStrict\Log\Config\LoggingConfig;

return [
    // Cache operations can run for every request and queue job. Enable these logs only when debugging cache behavior.
    // This provider file is a config file even though it lives outside the root config directory.
    // @phpstan-ignore larastan.noEnvCallsOutsideOfConfig
    LoggingConfig::KeyCacheLogging => (bool) env('LARASTRICT_CACHE_LOGGING', false),
];
