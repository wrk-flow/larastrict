<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Console\Kernel;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Testing\LaraStrictTestServiceProvider;
use Tests\LaraStrict\Feature\TestCase;

class LaraStrictTestServiceProviderTest extends TestCase
{
    public function makeExpectationCommandData(): array
    {
        return [
            [EnvironmentType::Production->value, false],
            [EnvironmentType::Production, false],
            ['test', false],
            ['beta', false],
            ['stage', false],
            [EnvironmentType::Testing, true],
            [EnvironmentType::Testing->value, true],
            [EnvironmentType::Local, true],
            [EnvironmentType::Local->value, true],
        ];
    }

    /**
     * @dataProvider makeExpectationCommandData
     */
    public function testMakeExpectationCommand(string|EnvironmentType $environment, bool $has): void
    {
        /** @var Repository $config */
        $config = $this->app->get(Repository::class);
        $config->set('app.env', $environment);

        $this->app->register(LaraStrictTestServiceProvider::class);

        /** @var Kernel $kernel */
        $kernel = $this->app->make(Kernel::class);

        $this->assertEquals($has, array_key_exists('make:expectation', $kernel->all()));
    }
}
