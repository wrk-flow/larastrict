<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers;

use Illuminate\Contracts\View\Factory;
use LaraStrict\Core\LaraStrictServiceProvider;
use Tests\LaraStrict\Feature\Providers\Translations\TestTranslation;
use Tests\LaraStrict\Feature\TestCase;

class AbstractServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(TestServiceProvider::class);
    }

    public function testCustomServiceFileName(): void
    {
        /** @var LaraStrictServiceProvider $serviceProvider */
        $serviceProvider = $this->app->getProvider(TestServiceProvider::class);
        $result = $serviceProvider->getAppServiceProvider();

        $this->assertEquals('Providers', $result->serviceName);
        $this->assertEquals('test_provider', $result->serviceFileName);
        $this->assertStringEndsWith('tests/Feature/Providers', $result->serviceRootDir);
        $this->assertEquals(__NAMESPACE__, $result->namespace);
        $this->assertSame($this->app, $result->application);
        $this->assertSame($serviceProvider, $result->serviceProvider);
    }

    public function testRegistersTranslations(): void
    {
        /** @var TestTranslation $testTranslation */
        $testTranslation = $this->app->make(TestTranslation::class);

        $this->assertEquals('translation test', $testTranslation->getTest());
    }

    public function testLoadViewsAndComponents(): void
    {
        /** @var Factory $viewFactory */
        $viewFactory = $this->app->make(Factory::class);

        $result = $viewFactory->make('Providers::layout');
        $this->assertEquals('Renders inline component
 and class component', $result->render());
    }
}
