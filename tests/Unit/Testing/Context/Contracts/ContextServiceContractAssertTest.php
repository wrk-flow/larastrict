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
        $boolValue = new BoolContextValue(true);

        $isContext = new IsContext(1);
        $isCallback = static function (string $string): bool {
            self::assertEquals('test', $string);
            return true;
        };
        return [
            new AssertExpectationEntity(
                'delete',
                static fn () => new ContextServiceContractAssert([
                    new ContextServiceContractDeleteExpectation($context),
                ]),
                static fn (ContextServiceContractAssert $assert) => $assert->delete($context),
            ),
            new AssertExpectationEntity(
                'set',
                static fn () => new ContextServiceContractAssert([], [
                    new ContextServiceContractSetExpectation($context, $value),
                ]),
                static fn (ContextServiceContractAssert $assert) => $assert->set(
                    $context,
                    $value,
                ),
            ),
            new AssertExpectationEntity(
                'setWithoutCache',
                static fn () => new ContextServiceContractAssert([], [], [
                    new ContextServiceContractSetWithoutCacheExpectation($context, $value),
                ]),
                static fn (ContextServiceContractAssert $assert) => $assert->setWithoutCache(
                    $context,
                    $value,
                ),
            ),
            new AssertExpectationEntity('get', static fn() => new ContextServiceContractAssert([], [], [], [
                new ContextServiceContractGetExpectation(
                    $value,
                    $context,
                    static function (
                        AbstractContext $context,
                        Closure $createState,
                        ContextServiceContractGetExpectation $expectation,
                    ) use ($value): void {
                        self::assertSame($value, $createState('test'));
                    },
                ),
            ]), static fn(ContextServiceContractAssert $assert) => $assert->get(
                $context,
                // The container-style callback deliberately declares its injected argument.
                // @phpstan-ignore argument.type
                static function (string $string) use ($value): TestValue {
                    self::assertEquals('test', $string);
                    return $value;
                },
            ), true, false, $value),
            new AssertExpectationEntity('get', static fn () => new ContextServiceContractAssert([], [], [], [
                new ContextServiceContractGetExpectation($value, $context, null, static function (Closure $createState): TestValue {
                    $result = $createState('test');
                    assert($result instanceof TestValue);
                    return $result;
                }),
            ]), static fn(ContextServiceContractAssert $assert) => $assert->get(
                $context,
                // @phpstan-ignore argument.type
                static function (string $string) use ($value): TestValue {
                    self::assertEquals('test', $string);
                    return $value;
                },
            ), true, false, $value),
            new AssertExpectationEntity('is', static fn() => new ContextServiceContractAssert([], [], [], [], [
                new ContextServiceContractIsExpectation(
                    $boolValue,
                    $isContext,
                    $isCallback,
                    static function (
                        AbstractContext $context,
                        Closure $is,
                        ContextServiceContractIsExpectation $expectation,
                    ): void {
                        self::assertTrue($is('test'));
                    },
                ),
            ]), static fn(ContextServiceContractAssert $assert) => $assert->is(
                $isContext,
                // @phpstan-ignore argument.type
                $isCallback,
            ), true, false, $boolValue),
            new AssertExpectationEntity('getCacheKey', static fn () => new ContextServiceContractAssert([], [], [], [], [], [
                new ContextServiceContractGetCacheKeyExpectation('key', $context),
            ]), static fn (ContextServiceContractAssert $assert) => $assert->getCacheKey($context), true, false, 'key'),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new ContextServiceContractAssert();
    }
}
