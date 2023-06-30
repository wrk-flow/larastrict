<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Laravel;

use Closure;
use Illuminate\Container\ContextualBindingBuilder;
use Illuminate\Contracts\Container\BindingResolutionException;
use LaraStrict\Testing\Laravel\TestingContainer;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestAction;

class TestingContainerTest extends TestCase
{
    final public const Args = ['arg1'];
    final public const Abstract = 'test';

    public function make(): array
    {
        $action = new TestAction();

        return [
            'supports given object' => [$action, $action],
            'supports make via closure' => [function (array $arguments, string $abstract) use ($action) {
                $this->assertEquals(self::Args, $arguments);
                $this->assertEquals(self::Abstract, $abstract);

                return $action;
            }, $action],
        ];
    }

    /**
     * @dataProvider make
     */
    public function testMakeConstructSupportsObjectOrClosure(object $make, object $expectedResult): void
    {
        $container = new TestingContainer([
            self::Abstract => $make,
        ]);

        $this->assertMake($container, $expectedResult);
    }

    /**
     * @dataProvider make
     */
    public function testMakeSupportsObjectOrClosure(object $make, object $expectedResult): void
    {
        $container = new TestingContainer();
        $container->makeReturns(self::Abstract, $make);

        $this->assertMake($container, $expectedResult);
    }

    /**
     * @dataProvider make
     */
    public function testAlwaysBindingConstructSupportsObjectOrClosure(object $make, object $expectedResult): void
    {
        $container = new TestingContainer(makeAlwaysBinding: $make);

        $this->assertMake($container, $expectedResult);
    }

    /**
     * @dataProvider make
     */
    public function testAlwaysBindingSupportsObjectOrClosure(object $make, object $expectedResult): void
    {
        $container = new TestingContainer();
        $container->makeAlwaysReturn($make);

        $this->assertMake($container, $expectedResult);
    }

    public function makeException(): array
    {
        $messageNull = 'Binding not set ' . self::Abstract;
        $messageClosureNull = 'Failed to resolve ' . self::Abstract;

        return [
            'when make binding does not exists' => [false, $messageNull],
            'when make binding is null' => [true, $messageNull, null],
            'closure returns null' => [
                true,
                $messageClosureNull,
                static fn (): mixed => null,
            ],
        ];
    }

    /**
     * @dataProvider makeException
     */
    public function testBindingResolutionException(
        bool $setMake,
        string $expectedMessage,
        mixed $value = null
    ): void {
        $container = new TestingContainer();

        if ($setMake) {
            $container->makeReturns(self::Abstract, $value);
            $this->expectExceptionMessage($expectedMessage);
        } else {
            $this->expectExceptionMessage('Binding not set ' . self::Abstract);
        }

        $this->expectException(BindingResolutionException::class);

        $container->make(self::Abstract);
    }

    public function testBoundNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $this->assertFalse($container->bound(self::Abstract));
        });
    }

    public function testAliasNotImplemented(): void
    {
        $this->assertNotImplemented(static function (TestingContainer $container): void {
            $container->alias(self::Abstract, 'alias');
        });
    }

    public function testTagNotImplemented(): void
    {
        $this->assertNotImplemented(static function (TestingContainer $container): void {
            $container->tag(self::Abstract, ['tag']);
        });
    }

    public function testTaggedImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $this->assertEmpty($container->tagged(self::Abstract));
        });
    }

    public function testBindNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->bind(self::Abstract, $this->failClosure());
        });
    }

    public function testBindIfNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->bindIf(self::Abstract, $this->failClosure());
        });
    }

    public function testSingletonNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->singleton(self::Abstract, $this->failClosure());
        });
    }

    public function testSingletonIfNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->singletonIf(self::Abstract, $this->failClosure());
        });
    }

    public function testScopedNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->scoped(self::Abstract, $this->failClosure());
        });
    }

    public function testScopedIfNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->scopedIf(self::Abstract, $this->failClosure());
        });
    }

    public function testExtendNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->extend(self::Abstract, $this->failClosure());
        });
    }

    public function testInstanceNotImplemented(): void
    {
        $this->assertNotImplemented(static function (TestingContainer $container): void {
            $container->instance(self::Abstract, new TestAction());
        });
    }

    public function testAddContextualBindingNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->addContextualBinding(TestAction::class, self::Abstract, $this->failClosure());
        });
    }

    public function testWhenNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $result = $container->when(self::Abstract);
            $this->assertInstanceOf(ContextualBindingBuilder::class, $result);
        });
    }

    public function testFactoryNotImplemented(): void
    {
        $this->assertNotImplemented(static function (TestingContainer $container): void {
            $closure = $container->factory(self::Abstract);
            $closure();
        });
    }

    public function testFlushNotImplemented(): void
    {
        $this->assertNotImplemented(static function (TestingContainer $container): void {
            $container->flush();
        });
    }

    public function testCallNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->call($this->failClosure());
        });
    }

    public function testResolvedNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $this->assertFalse($container->resolved(self::Abstract));
        });
    }

    public function testResolvingNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->resolving(self::Abstract, $this->failClosure());
        });
    }

    public function testAfterResolvingNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $container->afterResolving(self::Abstract, $this->failClosure());
        });
    }

    public function testGetNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $this->assertNull($container->get(self::Abstract));
        });
    }

    public function testHasNotImplemented(): void
    {
        $this->assertNotImplemented(function (TestingContainer $container): void {
            $this->assertFalse($container->has(self::Abstract));
        });
    }

    protected function assertMake(TestingContainer $container, object $expectedResult): void
    {
        $result = $container->make(self::Abstract, self::Args);

        $this->assertSame($expectedResult, $result);
    }

    protected function defaultContainer(): TestingContainer
    {
        return new TestingContainer([
            self::Abstract => new TestAction(),
        ]);
    }

    protected function failClosure(): Closure
    {
        return function (): never {
            $this->fail('Closure should not be called');
        };
    }

    protected function assertDefaultContainerMake(TestingContainer $container): void
    {
        $this->assertInstanceOf(TestAction::class, $container->make(self::Abstract));
    }

    /**
     * @param Closure(TestingContainer):void $run
     */
    protected function assertNotImplemented(Closure $run): void
    {
        $container = $this->defaultContainer();
        $run($container);
        $this->assertDefaultContainerMake($container);

        $this->assertEquals(
            $this->defaultContainer(),
            $container,
            'container that should not be changed if not implemented'
        );
    }
}
