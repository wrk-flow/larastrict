<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Providers\Pipes\BootViewComposersPipe;

use Illuminate\Contracts\View\Factory;
use LaraStrict\Contracts\HasViewComposers;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;
use LaraStrict\Providers\Pipes\BootViewComposersPipe;
use LaraStrict\Testing\Concerns\TestData;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryAssert;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryComposerExpectation;
use LaraStrict\Testing\Laravel\TestingApplication;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Unit\Testing\Laravel\Composer;

class BootViewComposersPipeTest extends TestCase
{
    use TestData;
    final public const ServiceName = 'Test';

    public function data(): array
    {
        $app = new TestingApplication();
        $viewFactory = new FactoryAssert();
        return [
            'implements' => [
                fn (self $self) => $self->assert(
                    app: $app,
                    serviceProvider: new class(
                        $app,
                        $viewFactory
                    ) extends AbstractServiceProvider implements HasViewComposers {
                        public function __construct(
                            TestingApplication $app,
                            private readonly Factory $viewFactory,
                        ) {
                            parent::__construct($app);
                        }

                        public function bootViewComposers(string $serviceName, Factory $viewFactory): void
                        {
                            Assert::assertEquals('Test', $serviceName);
                            Assert::assertSame($this->viewFactory, $viewFactory);

                            $viewFactory->composer(['test'], Composer::class);
                        }
                    },
                    viewFactory: $viewFactory,
                    factoryComposerExpectation: new FactoryComposerExpectation(
                        return: null,
                        views: ['test'],
                        callback: Composer::class,
                    ),
                ),
            ],
            'does not implement' => [
                static fn (self $self) => $self->assert(
                    app: $app,
                    serviceProvider: new class($app) extends AbstractServiceProvider {
                    },
                    viewFactory: $viewFactory,
                    factoryComposerExpectation: null,
                ),
            ],
        ];
    }

    public function assert(
        TestingApplication $app,
        AbstractServiceProvider $serviceProvider,
        FactoryAssert $viewFactory,
        ?FactoryComposerExpectation $factoryComposerExpectation,
    ): void {
        $pipe = new BootViewComposersPipe(viewFactory: $viewFactory);

        if ($factoryComposerExpectation !== null) {
            $viewFactory->addExpectation($factoryComposerExpectation);
        }

        $appServiceProvider = new AppServiceProviderEntity(
            application: $app,
            serviceProvider: $serviceProvider,
            serviceName: self::ServiceName,
            serviceFileName: 'test',
            serviceRootDir: __DIR__,
            namespace: __NAMESPACE__,
        );
        $called = false;
        $pipe->handle(appServiceProvider: $appServiceProvider, next: static function () use (&$called) {
            $called = true;
        });

        $this->assertTrue($called, '$next should be called');

        $viewFactory->assertCalled();
    }
}
