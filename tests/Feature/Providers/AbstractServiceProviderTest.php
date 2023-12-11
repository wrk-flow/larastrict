<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers;

use Illuminate\Contracts\View\Factory;
use LaraStrict\Core\LaraStrictServiceProvider;
use LaraStrict\Providers\Actions\CreateAppServiceProviderAction;
use Tests\LaraStrict\Feature\Providers\Actions\DITestImplementationAction;
use Tests\LaraStrict\Feature\Providers\Actions\TestImplementationAction;
use Tests\LaraStrict\Feature\Providers\Interfaces\TestImplementationInterface;
use Tests\LaraStrict\Feature\Providers\Translations\TestTranslation;
use Tests\LaraStrict\Feature\TestCase;

class AbstractServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app()
            ->register(TestServiceProvider::class);
    }

    public function testCustomServiceFileName(): void
    {
        /** @var LaraStrictServiceProvider $serviceProvider */
        $serviceProvider = $this->app()
            ->getProvider(TestServiceProvider::class);
        $result = $serviceProvider->getAppServiceProvider();

        $this->assertEquals('Providers', $result->serviceName);
        $this->assertEquals('test_provider', $result->serviceFileName);
        $this->assertStringEndsWith('tests/Feature/Providers', $result->serviceRootDir);
        $this->assertEquals(__NAMESPACE__, $result->namespace);
        $this->assertSame($this->app(), $result->application);
        $this->assertSame($serviceProvider, $result->serviceProvider);
    }

    public function testRegistersTranslations(): void
    {
        /** @var TestTranslation $testTranslation */
        $testTranslation = $this->app()
            ->make(TestTranslation::class);

        $this->assertEquals('translation test', $testTranslation->getTest());
    }

    public function testLoadViewsAndComponents(): void
    {
        /** @var Factory $viewFactory */
        $viewFactory = $this->app()
            ->make(Factory::class);

        $result = $viewFactory->make('Providers::layout');
        $this->assertEquals('Renders inline component' . PHP_EOL . ' and class component', $result->render());
    }

    public function testGiveTaggedImplementation(): void
    {
        $this->app()
            ->tag([TestImplementationAction::class], [TestImplementationInterface::class]);

        $action = $this->app()
            ->make(DITestImplementationAction::class);
        $this->assertInstanceOf(DITestImplementationAction::class, $action);
    }

    public function testGiveTaggedImplementationFailsOnIncorrectService(): void
    {
        $this->app()
            ->tag([
                TestImplementationAction::class,
                CreateAppServiceProviderAction::class,
            ], [TestImplementationInterface::class]);

        $this->expectExceptionMessage(
            sprintf(
                'Tagged implementation for %s must be instance of %s',
                CreateAppServiceProviderAction::class,
                TestImplementationInterface::class
            )
        );
        $this->app()
            ->make(DITestImplementationAction::class);
    }
}
