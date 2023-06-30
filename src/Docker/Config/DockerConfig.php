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
        return $this->get(keyOrPath: self::KeyInDockerEnvironment);
    }

    public function setIsInDockerEnvironment(bool $value): void
    {
        $this->set(keyOrPath: self::KeyInDockerEnvironment, value: $value);
    }

    public function getDockerOutputProcess(): string
    {
        return $this->get(keyOrPath: self::KeyOutputProcess);
    }

    protected function getServiceProvider(): string
    {
        return DockerServiceProvider::class;
    }
}
