<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Values\BoolContextValue;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Context\Contracts\ContextServiceContractAssert;
use LaraStrict\Testing\Context\Contracts\ContextServiceContractDeleteExpectation;
use LaraStrict\Testing\Context\Contracts\ContextServiceContractGetCacheKeyExpectation;
use LaraStrict\Testing\Context\Contracts\ContextServiceContractGetExpectation;
use LaraStrict\Testing\Context\Contracts\ContextServiceContractIsExpectation;
use LaraStrict\Testing\Context\Contracts\ContextServiceContractSetExpectation;
use LaraStrict\Testing\Context\Contracts\ContextServiceContractSetWithoutCacheExpectation;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Context\Services\IsContext;
use Tests\LaraStrict\Feature\Context\Services\TestNoDependencyContext;
use Tests\LaraStrict\Feature\Context\Services\TestValue;

class ContextServiceContractAssertTest extends TestCase
{
    use AssertExpectations;

    public static function generateData(): array
    {
        $context = new TestNoDependencyContext('test');
        $value = new TestValue('test');
        $boolValue = new BoolContextValue(is: true);

        $isContext = new IsContext(id: 1);
        return [
            new AssertExpectationEntity(
                methodName: 'delete',
                createAssert: static fn () => new ContextServiceContractAssert(delete: [
                    new ContextServiceContractDeleteExpectation(context: $context),
                ]),
                call: static fn (ContextServiceContractAssert $assert) => $assert->delete(context: $context),
            ),
            new AssertExpectationEntity(
                methodName: 'set',
                createAssert: static fn () => new ContextServiceContractAssert(set: [
                    new ContextServiceContractSetExpectation(context: $context, value: $value),
                ]),
                call: static fn (ContextServiceContractAssert $assert) => $assert->set(
                    context: $context,
                    value: $value,
                ),
            ),
            new AssertExpectationEntity(
                methodName: 'setWithoutCache',
                createAssert: static fn () => new ContextServiceContractAssert(setWithoutCache: [
                    new ContextServiceContractSetWithoutCacheExpectation(context: $context, value: $value),
                ]),
                call: static fn (ContextServiceContractAssert $assert) => $assert->setWithoutCache(
                    context: $context,
                    value: $value,
                ),
            ),
            new AssertExpectationEntity(
                methodName: 'get',
                createAssert: static fn() => new ContextServiceContractAssert(get: [
                    new ContextServiceContractGetExpectation(
                        return: $value,
                        context: $context,
                        hook: static function (
                            AbstractContext $context,
                            Closure $createState,
                            ContextServiceContractGetExpectation $expectation,
                        ) use ($value): void {
                            self::assertSame($value, $createState('test'));
                        },
                    ),
                ]),
                call: static fn(ContextServiceContractAssert $assert) => $assert->get(
                    context: $context,
                    createState: static function (string $string) use ($value): TestValue {
                        self::assertEquals(expected: 'test', actual: $string);
                        return $value;
                    },
                ),
                checkResult: true,
                expectedResult: $value,
            ),
            new AssertExpectationEntity(
                methodName: 'get',
                createAssert: static fn () => new ContextServiceContractAssert(get: [
                    new ContextServiceContractGetExpectation(
                        return: $value,
                        context: $context,
                        runCreateState: static fn (Closure $createState): TestValue => $createState('test'),
                    ),
                ]),
                call: static fn(ContextServiceContractAssert $assert) => $assert->get(
                    context: $context,
                    createState: static function (string $string) use ($value): TestValue {
                        self::assertEquals(expected: 'test', actual: $string);
                        return $value;
                    },
                ),
                checkResult: true,
                expectedResult: $value,
            ),
            new AssertExpectationEntity(
                methodName: 'is',
                createAssert: static fn() => new ContextServiceContractAssert(is: [
                    new ContextServiceContractIsExpectation(
                        return: $boolValue,
                        context: $isContext,
                        is: static function () {
                        },
                        hook: static function (
                            AbstractContext $context,
                            Closure $is,
                            ContextServiceContractIsExpectation $expectation,
                        ): void {
                            self::assertTrue(condition: $is('test'));
                        },
                    ),
                ]),
                call: static fn(ContextServiceContractAssert $assert) => $assert->is(
                    context: $isContext,
                    is: static function (string $string): bool {
                        self::assertEquals(expected: 'test', actual: $string);
                        return true;
                    },
                ),
                checkResult: true,
                expectedResult: $boolValue,
            ),
            new AssertExpectationEntity(
                methodName: 'getCacheKey',
                createAssert: static fn () => new ContextServiceContractAssert(getCacheKey: [
                    new ContextServiceContractGetCacheKeyExpectation(return: 'key', context: $context),
                ]),
                call: static fn (ContextServiceContractAssert $assert) => $assert->getCacheKey(context: $context),
                checkResult: true,
                expectedResult: 'key',
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new ContextServiceContractAssert();
    }
}
