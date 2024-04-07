<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Context\Services;

use Closure;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Services\ContextService;
use LaraStrict\Context\Values\BoolContextValue;
use LaraStrict\Core\Services\ImplementsService;
use LaraStrict\Testing\Cache\Contracts\CacheMeServiceContractAssert;
use LaraStrict\Testing\Cache\Contracts\CacheMeServiceContractGetExpectation;
use LaraStrict\Testing\Concerns\TestData;
use LaraStrict\Testing\Laravel\TestingContainer;
use PHPUnit\Framework\TestCase;

class ContextServiceTest extends TestCase
{
    use TestData;

    public static function data(): array
    {
        return [
            [
                static fn (self $self) => $self->assert(
                    context: new TestDependencyContext(value: 'test'),
                    assert: static fn (TestValue $value) => $self->assertEquals('test', $value->value),
                    callHook: static fn (Closure $getValue) => $getValue('test'),
                    expectedCacheKey: 'Tests\LaraStrict\Feature\Context\Services\TestDependencyContext-test',
                ),
            ],
            [
                static fn (self $self) => $self->assert(
                    context: new TestNoDependencyContext(value: 'test'),
                    assert: static fn (TestValue $value) => $self->assertEquals('test', $value->value),
                    callHook: static fn (Closure $getValue) => $getValue(),
                    expectedCacheKey: 'Tests\LaraStrict\Feature\Context\Services\TestNoDependencyContext-test',
                ),
            ],
            [
                static fn (self $self) => $self->assert(
                    context: new IsContext(id: 1),
                    assert: static fn (BoolContextValue $value) => $self->assertEquals(true, $value->isValid()),
                    callHook: static fn (Closure $getValue) => $getValue(
                        new TestingContainer(
                            call: static fn (Closure $getValue): bool => $getValue(true),
                        ),
                    ),
                    expectedCacheKey: 'Tests\LaraStrict\Feature\Context\Services\IsContext-1',
                ),
            ],
            [
                static fn (self $self) => $self->assert(
                    context: new IsContext(id: 1),
                    assert: static fn (BoolContextValue $value) => $self->assertEquals(false, $value->isValid()),
                    callHook: static fn (Closure $getValue) => $getValue(
                        new TestingContainer(
                            call: static fn (Closure $getValue): bool => $getValue(false),
                        ),
                    ),
                    expectedCacheKey: 'Tests\LaraStrict\Feature\Context\Services\IsContext-1',
                ),
            ],
        ];
    }

    public function assert(
        AbstractContext $context,
        Closure $assert,
        Closure $callHook,
        string $expectedCacheKey,
    ): void {
        $service = new ContextService(
            cacheMeManager: new CacheMeServiceContractAssert(get: [
                new CacheMeServiceContractGetExpectation(
                    key: $expectedCacheKey,
                    tags: [],
                    minutes: 3600,
                    strategy: CacheMeStrategy::Memory,
                    callGetValueHook: $callHook,
                ),
            ]),
            implementsService: new ImplementsService(),
        );

        $value = $context->get($service);

        $assert($value);
    }
}
