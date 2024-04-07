<?php

declare(strict_types=1);

namespace LaraStrict\Docker\Config;

use LaraStrict\Config\AbstractProviderConfig;
use LaraStrict\Docker\DockerServiceProvider;

class DockerConfig extends AbstractProviderConfig
{
    final public const KeyInDockerEnvironment = 'in_docker_environment';
    final public const KeyOutputProcess = 'output_process';

    public function isInDockerEnvironment(): bool
    {
        $bool = $this->get(keyOrPath: self::KeyInDockerEnvironment);
        assert(is_bool($bool) || is_string($bool) || is_int($bool));

        return (bool) $bool;
    }

    public function setIsInDockerEnvironment(bool $value): void
    {
        $this->set(keyOrPath: self::KeyInDockerEnvironment, value: $value);
    }

    public function getDockerOutputProcess(): string
    {
        $value = $this->get(keyOrPath: self::KeyOutputProcess);
        assert(is_string($value));
        return $value;
    }

    protected function getServiceProvider(): string
    {
        return DockerServiceProvider::class;
    }
}
