<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Docker\Config;

use Closure;
use LaraStrict\Docker\Config\DockerConfig;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LaraStrict\Feature\Config\Laravel\AbstractConfigTestCase;

class DockerConfigTest extends AbstractConfigTestCase
{
    private DockerConfig $config;

    protected function setUp(): void
    {
        parent::setUp();

        $this->config = $this->app()
            ->make(DockerConfig::class);
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataIsInDockerEnvironment(): array
    {
        return [
            'default should be false' => [
                static fn (self $self) => $self->assertIsInDockerEnvironment(
                    set: null, // We expect that $this->get usage in config does not use "default" value
                    expected: false,
                ),
            ],
            'set true, returns true' => [
                static fn (self $self) => $self->assertIsInDockerEnvironment(set: true, expected: true),
            ],
            'set false, returns false' => [
                static fn (self $self) => $self->assertIsInDockerEnvironment(set: false, expected: false),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('dataIsInDockerEnvironment')]
    public function testIsInDockerEnvironment(Closure $assert): void
    {
        $assert($this);
    }

    public function assertIsInDockerEnvironment(?bool $set, bool $expected): void
    {
        if ($set !== null) {
            $this->setRepositoryValue(keys: [DockerConfig::KeyInDockerEnvironment], value: $set);
        }

        $this->assertEquals(expected: $expected, actual: $this->config->isInDockerEnvironment());
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataGetDockerOutputProcess(): array
    {
        return [
            'default should be /proc/1/fd/1' => [
                static fn (self $self) => $self->assertGetDockerOutputProcess(set: null, expected: '/proc/1/fd/1'),
            ],
            'set /proc/1/fd/2, returns /proc/1/fd/2' => [
                static fn (self $self) => $self->assertGetDockerOutputProcess(
                    set: '/proc/1/fd/2',
                    expected: '/proc/1/fd/2',
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('dataGetDockerOutputProcess')]
    public function testGetDockerOutputProcess(Closure $assert): void
    {
        $assert($this);
    }

    public function assertGetDockerOutputProcess(?string $set, string $expected): void
    {
        if ($set !== null) {
            $this->setRepositoryValue(keys: [DockerConfig::KeyOutputProcess], value: $set);
        }

        $this->assertEquals(expected: $expected, actual: $this->config->getDockerOutputProcess());
    }

    protected function getConfigName(): string
    {
        return 'docker';
    }
}
