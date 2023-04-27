<?php

declare(strict_types=1);

namespace LaraStrict\Config\Laravel;

use LaraStrict\Config\AbstractConfig;
use LaraStrict\Enums\EnvironmentType;

class AppConfig extends AbstractConfig
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
        return (string) ($this->get(self::KeyVersion, null, true) ?? 'DEV.' . time());
    }

    public function getKey(): string
    {
        return $this->get(self::KeyKey);
    }

    public function getUrl(): string
    {
        return $this->get(self::KeyUrl, emptyToDefault: true);
    }

    public function getAssetUrl(): ?string
    {
        return $this->get(self::KeyAssetUrl, null, true);
    }

    public function getName(): string
    {
        return $this->get(self::KeyName, emptyToDefault: true);
    }

    public function isInDebugMode(): bool
    {
        return (bool) $this->get(self::KeyDebug, false, true);
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

        $envType = EnvironmentType::tryFrom($env);

        if ($envType instanceof EnvironmentType === false) {
            return $env;
        }

        return $envType;
    }

    protected function getConfigFileName(): string
    {
        return 'app';
    }
}
