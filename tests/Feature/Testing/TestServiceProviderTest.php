<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Console\Kernel;
use LaraStrict\Core\LaraStrictServiceProvider;
use LaraStrict\Enums\EnvironmentType;
use Tests\LaraStrict\Feature\TestCase;

class TestServiceProviderTest extends TestCase
{
    public function makeExpectationCommandData(): array
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

    /**
     * @dataProvider makeExpectationCommandData
     */
    public function testMakeExpectationCommand(string|EnvironmentType $environment, bool $has): void
    {
        /** @var Repository $config */
        $config = $this->app()
            ->get(Repository::class);
        $config->set('app.env', $environment);

        $this->app()
            ->register(LaraStrictServiceProvider::class);

        /** @var Kernel $kernel */
        $kernel = $this->app()
            ->make(Kernel::class);

        $this->assertEquals($has, array_key_exists('make:expectation', $kernel->all()));
    }

    protected function getPackageProviders($app)
    {
        return [];
    }
}
