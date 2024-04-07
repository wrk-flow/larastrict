<?php

declare(strict_types=1);

namespace LaraStrict\Config\Laravel;

use LaraStrict\Config\AbstractConfig;
use LaraStrict\Config\Contracts\AppConfigContract;
use LaraStrict\Enums\EnvironmentType;

class AppConfig extends AbstractConfig implements AppConfigContract
{
    final public const KeyEnv = 'env';
    final public const ConfigName = 'app';
    final public const KeyKey = 'key';
    final public const KeyUrl = 'url';
    final public const KeyAssetUrl = 'asset_url';
    final public const KeyName = 'name';
    final public const KeyDebug = 'debug';
    final public const KeyVersion = 'version';

    /**
     * Version from an app (Larastrict projects uses app.version).
     */
    public function getVersion(): string
    {
        $value = ($this->get(self::KeyVersion, null, true) ?? 'DEV.' . time());
        assert(is_string($value) || is_numeric($value));
        return (string) $value;
    }

    public function getKey(): string
    {
        $value = $this->get(self::KeyKey);
        assert(is_string($value));
        return $value;
    }

    public function getUrl(): string
    {
        $value = $this->get(self::KeyUrl, emptyToDefault: true);
        assert(is_string($value));
        return $value;
    }

    public function getAssetUrl(): ?string
    {
        $value = $this->get(self::KeyAssetUrl, null, true);
        if ($value === null) {
            return null;
        }

        assert(is_string($value));
        return $value;
    }

    public function getName(): string
    {
        $value = $this->get(self::KeyName, emptyToDefault: true);
        assert(is_string($value));
        return $value;
    }

    public function isInDebugMode(): bool
    {
        $value = $this->get(self::KeyDebug, false, true);
        assert(is_bool($value) || is_numeric($value) || is_string($value));
        return (bool) $value;
    }

    public function getEnvironment(): EnvironmentType|string
    {
        $env = $this->get(self::KeyEnv, 'production', true);

        if ($env instanceof EnvironmentType) {
            return $env;
        }

        if (is_int($env)) {
            $env = 'production';
        }
        assert(is_string($env));

        $envType = EnvironmentType::tryFrom($env);

        if ($envType instanceof EnvironmentType === false) {
            return $env;
        }

        return $envType;
    }

    protected function getConfigFileName(): string
    {
        return self::ConfigName;
    }
}
