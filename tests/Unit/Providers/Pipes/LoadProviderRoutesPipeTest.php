<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Providers\Pipes;

use LaraStrict\Contracts\HasCustomRoutes;
use LaraStrict\Contracts\HasRoutes;
use LaraStrict\Contracts\RegisterCustomRouteActionContract;
use LaraStrict\Contracts\RegisterNamedCustomRouteActionContract;
use LaraStrict\Entities\AppServiceProviderEntity;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Pipes\LoadProviderRoutesPipe;
use LaraStrict\Testing\Laravel\TestingApplication;
use LaraStrict\Testing\Laravel\TestingApplicationRoutes;
use LaraStrict\Testing\Laravel\TestingContainer;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use stdClass;

class LoadProviderRoutesPipeTest extends TestCase
{
    public function invalidNumericRoutes(): array
    {
        return [[1], [[]], [new stdClass()]];
    }

    /**
     * @dataProvider invalidNumericRoutes
     */
    public function testNumericIndexMustHaveStringValue(mixed $customRoute): void
    {
        $this->assertInvalidRoutes(
            [$customRoute],
            'Custom route with numeric key expects file suffix name (value as string)'
        );
    }

    /**
     * @dataProvider invalidStringRoutes
     */
    public function testStringIndexMustHaveClosureOrString(mixed $customRoute): void
    {
        $this->assertInvalidRoutes([
            'test' => $customRoute,
        ], 'To build the custom route with file suffix name as key expects closure or class that implements ' . RegisterCustomRouteActionContract::class);
    }

    public function invalidStringRoutes(): array
    {
        return [[1], [[]], [new stdClass()]];
    }

    public function invalidRoutesClasses(): array
    {
        return [
            [[InvalidCustomRouteAction::class],
                'To build custom route with class you need to implement ' . RegisterNamedCustomRouteActionContract::class,
            ],
            [[
                'test' => InvalidCustomRouteAction::class,
            ], 'To build custom route with class you need to implement ' . RegisterCustomRouteActionContract::class],
        ];
    }

    /**
     * @dataProvider invalidRoutesClasses
     */
    public function testInvalidRoutesClasses(array $customRoutes, string $expectedMessage): void
    {
        $container = new TestingContainer(
            [
                InvalidCustomRouteAction::class => new InvalidCustomRouteAction(),
            ]
        );
        $this->assertInvalidRoutes(
            customRoutes: $customRoutes,
            expectedExceptionMessage: $expectedMessage,
            container: $container
        );
    }

    public function testCachedRoutesWillNotResolveAnything(): void
    {
        $this->assertInvalidRoutes(
            customRoutes: [InvalidCustomRouteAction::class],
            app: (new TestingApplicationRoutes())
                ->setRoutesAreCached()
        );
    }

    public function testWithoutCachedRoutes(): void
    {
        $this->assertInvalidRoutes(
            customRoutes: [InvalidCustomRouteAction::class],
            expectedExceptionMessage: 'Binding not set ' . InvalidCustomRouteAction::class,
            app: (new TestingApplicationRoutes())
        );
    }

    protected function assertInvalidRoutes(
        array $customRoutes,
        ?string $expectedExceptionMessage = null,
        TestingContainer $container = new TestingContainer(),
        TestingApplication $app = new TestingApplication()
    ): bool {
        if ($expectedExceptionMessage !== null) {
            $this->expectExceptionMessage($expectedExceptionMessage);
        }

        $pipe = new LoadProviderRoutesPipe($container, new NullLogger());
        $serviceProvider = new class(
            $app,
            $customRoutes
        ) extends AbstractServiceProvider implements HasCustomRoutes, HasRoutes {
            public function __construct(
                TestingApplication $app,
                private readonly array $customRoutes
            ) {
                parent::__construct($app);
            }

            public function getCustomRoutes(): array
            {
                return $this->customRoutes;
            }
        };
        $appServiceProvider = new AppServiceProviderEntity($app, $serviceProvider, 'test', __DIR__);

        $called = false;
        $pipe->handle($appServiceProvider, function ($givenAppServiceProvider) use (
            $appServiceProvider,
            &$called
        ): void {
            $called = true;

            $this->assertSame($appServiceProvider, $givenAppServiceProvider);
        });

        $this->assertTrue($called, '$next should be called');
        return $called;
    }
}
