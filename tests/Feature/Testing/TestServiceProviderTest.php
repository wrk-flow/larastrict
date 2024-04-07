<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Console\Kernel;
use LaraStrict\Core\Contracts\SleepServiceContract;
use LaraStrict\Core\LaraStrictServiceProvider;
use LaraStrict\Core\Services\SleepService;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Testing\Core\Services\NoSleepService;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LaraStrict\Feature\TestCase;

class TestServiceProviderTest extends TestCase
{
    public static function makeExpectationCommandData(): array
    {
        return [
            'production value' => [EnvironmentType::Production->value, false],
            'production env' => [EnvironmentType::Production, false],
            'test string' => ['test', false],
            'beta string' => ['beta', false],
            'stage string' => ['stage', false],
            'testing env' => [EnvironmentType::Testing, true],
            'testing string' => [EnvironmentType::Testing->value, true],
            'local env' => [EnvironmentType::Local, true],
            'local string' => [EnvironmentType::Local->value, true],
        ];
    }

    #[DataProvider('makeExpectationCommandData')]
    public function testMakeExpectationCommand(string|EnvironmentType $environment, bool $has): void
    {
        $this->setEnv($environment);

        $this->app()
            ->register(LaraStrictServiceProvider::class);

        $kernel = $this->app()
            ->make(Kernel::class);
        assert($kernel instanceof Kernel);

        $this->assertEquals($has, array_key_exists('make:expectation', $kernel->all()));
    }

    public function testSleepServiceInTests(): void
    {
        $this->app()
            ->register(LaraStrictServiceProvider::class);

        $this->assertInstanceOf(
            expected: NoSleepService::class,
            actual: $this->app()
                ->make(SleepServiceContract::class)
        );
    }

    public function testSleepServiceInProduction(): void
    {
        $this->setEnv(environment: EnvironmentType::Production);

        $this->app()
            ->register(LaraStrictServiceProvider::class);

        $service = $this->app()
            ->make(SleepServiceContract::class);

        // larastan will resolve this as NoSleepService - does not support dynamic env change.
        /** @phpstan-ignore-next-line  */
        $this->assertTrue($service instanceof SleepService);
    }

    protected function getPackageProviders($app)
    {
        return [];
    }

    protected function setEnv(string|EnvironmentType $environment): void
    {
        $config = $this
            ->app()
            ->get(Repository::class);

        assert($config instanceof Repository);
        $config->set('app.env', $environment);
    }
}
