<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Config\Laravel;

use LaraStrict\Config\Laravel\AppConfig;
use LaraStrict\Enums\EnvironmentType;

class AppConfigTest extends AbstractConfigTestCase
{
    private AppConfig $config;

    protected function setUp(): void
    {
        parent::setUp();

        $this->config = $this->app->make(AppConfig::class);
        $this->setRepositoryFromFile();
    }

    public function testVersion(): void
    {
        $expectationDefault = static fn ($value) => preg_match('#^DEV\.[\d]+$#', (string) $value) === 1;
        $this->assertConfigValue(
            expectedDefaultValue: $expectationDefault,
            keys: [AppConfig::KeyVersion],
            overridesExpectationMap: [
                'base64:test' => 'base64:test',
                '1234' => '1234',
                '' => $expectationDefault,
                'null' => $expectationDefault,
                0 => $expectationDefault,
                1 => '1',
            ],
            getValue: fn () => $this->config->getVersion()
        );
    }

    public function testKey(): void
    {
        $this->assertConfigValue(
            expectedDefaultValue: 'base64:2fl+Ktvkfl+Fuz4Qp/A75G2RTiWVA/ZoKZvp6fiiM10=',
            keys: [AppConfig::KeyKey],
            overridesExpectationMap: [
                'base64:test' => 'base64:test',
                '' => '',
            ],
            getValue: fn () => $this->config->getKey()
        );
    }

    public function testName(): void
    {
        $this->assertConfigValue(
            expectedDefaultValue: 'Laravel',
            keys: [AppConfig::KeyName],
            overridesExpectationMap: [
                'Test' => 'Test',
                '' => '',
                'null' => '',
            ],
            getValue: fn () => $this->config->getName()
        );
    }

    public function testGetUrl(): void
    {
        $this->assertConfigValue(
            expectedDefaultValue: 'http://localhost',
            keys: [AppConfig::KeyUrl],
            overridesExpectationMap: [
                'https://localhost' => 'https://localhost',
                '' => '',
                'null' => '',
            ],
            getValue: fn () => $this->config->getUrl()
        );
    }

    public function testGetAssetUrl(): void
    {
        $this->assertConfigValue(
            expectedDefaultValue: null,
            keys: [AppConfig::KeyAssetUrl],
            overridesExpectationMap: [
                'https://localhost' => 'https://localhost',
                '' => null,
                'null' => null,
            ],
            getValue: fn () => $this->config->getAssetUrl()
        );
    }

    public function testIsInDebugMode(): void
    {
        $this->assertConfigValue(
            expectedDefaultValue: false,
            keys: [AppConfig::KeyDebug],
            overridesExpectationMap: [
                false => false,
                true => true,
                'null' => false,
                '' => false,
            ],
            getValue: fn () => $this->config->isInDebugMode()
        );
    }

    /**
     * @dataProvider environmentDefaultData
     */
    public function testGetEnvironmentDefaultInvalidValues(mixed $value): void
    {
        $this->setEnv($value);

        $this->assertEquals(EnvironmentType::Production, $this->config->getEnvironment());
    }

    public function testGetEnvironmentDefault(): void
    {
        $this->assertEquals(EnvironmentType::Production, $this->config->getEnvironment());
    }

    /**
     * @dataProvider environmentTypeData
     */
    public function testGetEnvironmentType(string|EnvironmentType $value, string|EnvironmentType $expectedValue): void
    {
        $this->setEnv($value);

        $this->assertEquals($expectedValue, $this->config->getEnvironment());
    }

    protected function environmentDefaultData(): array
    {
        return [[''], [null], [0], [1]];
    }

    protected function environmentTypeData(): array
    {
        return [
            ['production', EnvironmentType::Production],
            [EnvironmentType::Production, EnvironmentType::Production],
            ['testing', EnvironmentType::Testing],
            ['local', EnvironmentType::Local],
            ['test', 'test'],
        ];
    }

    protected function setEnv(mixed $value): void
    {
        $this->setRepositoryValue([AppConfig::KeyEnv], $value);
    }

    protected function getConfigName(): string
    {
        return AppConfig::ConfigName;
    }
}
