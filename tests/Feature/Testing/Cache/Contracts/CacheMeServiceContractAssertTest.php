<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Cache\Contracts;

use LaraStrict\Cache\Enums\CacheMeStrategy;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use LaraStrict\Testing\Cache\Contracts\CacheMeServiceContractAssert;
use LaraStrict\Testing\Cache\Contracts\CacheMeServiceContractDeleteExpectation;
use LaraStrict\Testing\Cache\Contracts\CacheMeServiceContractFlushExpectation;
use LaraStrict\Testing\Cache\Contracts\CacheMeServiceContractGetExpectation;
use LaraStrict\Testing\Cache\Contracts\CacheMeServiceContractObserveAndFlushExpectation;
use LaraStrict\Testing\Cache\Contracts\CacheMeServiceContractSetExpectation;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Database\Models\Test;

class CacheMeServiceContractAssertTest extends TestCase
{
    use AssertExpectations;

    private const Return = 'test';

    private const Key = 'key';

    protected function generateData(): array
    {
        $closure = static fn () => 'test';
        return [
            new AssertExpectationEntity(
                methodName: 'get',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    get: [new CacheMeServiceContractGetExpectation(key: self::Key,)]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->get(
                    key: self::Key,
                    getValue: static fn () => self::Return
                ),
                checkResult: true,
                expectedResult: 'test'
            ),
            new AssertExpectationEntity(
                methodName: 'set',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    set: [new CacheMeServiceContractSetExpectation(
                        key: self::Key,
                        value: self::Return,
                        tags: [self::Return],
                        minutes: 230,
                        strategy: CacheMeStrategy::Memory
                    )]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->set(
                    key: self::Key,
                    value: self::Return,
                    tags: [self::Return],
                    minutes: 230,
                    strategy: CacheMeStrategy::Memory
                ),
                checkResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'set',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    set: [new CacheMeServiceContractSetExpectation(key: self::Key, value: self::Return)]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->set(
                    key: self::Key,
                    value: self::Return
                ),
                checkResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'flush',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    flush: [new CacheMeServiceContractFlushExpectation()]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->flush(),
                checkResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'flush',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    flush: [new CacheMeServiceContractFlushExpectation(
                        tags: [self::Return],
                        strategy: CacheMeStrategy::Memory
                    )]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->flush(
                    tags: [self::Return],
                    strategy: CacheMeStrategy::Memory
                ),
                checkResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'delete',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    delete: [new CacheMeServiceContractDeleteExpectation(key: self::Key,)]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->delete(key: self::Key,),
                checkResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'delete',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    delete: [new CacheMeServiceContractDeleteExpectation(
                        key: self::Key,
                        tags: [self::Return],
                        strategy: CacheMeStrategy::Memory
                    )]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->delete(
                    key: self::Key,
                    tags: [self::Return],
                    strategy: CacheMeStrategy::Memory
                ),
                checkResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'observeAndFlush',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    observeAndFlush: [new CacheMeServiceContractObserveAndFlushExpectation(
                        tags: [self::Key],
                        modelClass: Test::class,
                    )]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->observeAndFlush(
                    tags: [self::Key],
                    modelClass: Test::class,
                ),
                checkResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'observeAndFlush',
                createAssert: static fn () => new CacheMeServiceContractAssert(
                    observeAndFlush: [new CacheMeServiceContractObserveAndFlushExpectation(
                        tags: static fn () => 'test',
                        modelClass: Test::class,
                    )]
                ),
                call: static fn (CacheMeServiceContractAssert $assert) => $assert->observeAndFlush(
                    tags: $closure,
                    modelClass: Test::class,
                ),
                checkResult: false,
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new CacheMeServiceContractAssert();
    }
}
