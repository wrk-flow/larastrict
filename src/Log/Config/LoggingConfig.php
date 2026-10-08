<?php

declare(strict_types=1);

namespace LaraStrict\Log\Config;

use LaraStrict\Config\AbstractConfig;

final class LoggingConfig extends AbstractConfig
{
    public const string KeyCacheLogging = 'cache_logging';
    public const string ConfigName = 'log';

    public function isCacheLoggingEnabled(): bool
    {
        return $this->get(self::KeyCacheLogging, false) === true;
    }

    public function setCacheLoggingEnabled(bool $enabled): void
    {
        $this->set(self::KeyCacheLogging, $enabled);
    }

    protected function getConfigFileName(): string
    {
        return self::ConfigName;
    }
}
