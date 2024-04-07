<?php

declare(strict_types=1);

namespace LaraStrict\Config;

use Illuminate\Config\Repository;

abstract class AbstractConfig
{
    private readonly string $configFileName;

    public function __construct(
        private readonly Repository $config,
    ) {
        $this->configFileName = $this->getConfigFileName();
    }

    abstract protected function getConfigFileName(): string;

    /**
     * @param string[]|string $keyOrPath Provide path that will be joined to dot notation
     * @param bool            $emptyToDefault Convert empty value from repository to $default value.
     */
    protected function get(string|array $keyOrPath, mixed $default = '', bool $emptyToDefault = false): mixed
    {
        $result = $this->config->get($this->getPath($keyOrPath), $default);

        if ($emptyToDefault && ((is_string($result) === false && is_bool($result)) || empty($result))) {
            return $default;
        }

        return $result;
    }

    /**
     * @param string[]|string $keyOrPath Provide path that will be joined to dot notation
     */
    protected function set(string|array $keyOrPath, mixed $value = null): void
    {
        $this->config->set($this->getPath($keyOrPath), $value);
    }

    protected function getPath(array|string $keyOrPath): string
    {
        if (is_array($keyOrPath)) {
            $keyOrPath = implode('.', $keyOrPath);
        }

        return $this->configFileName . '.' . $keyOrPath;
    }
}
