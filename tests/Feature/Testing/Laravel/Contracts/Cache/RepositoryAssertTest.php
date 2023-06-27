<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\Cache;

use Illuminate\Cache\NullStore;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryAddExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryAssert;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryClearExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryDecrementExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryDeleteExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryDeleteMultipleExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryForeverExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryForgetExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryGetExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryGetMultipleExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryGetStoreExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryHasExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryIncrementExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryPullExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryPutExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryRememberExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositoryRememberForeverExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositorySearExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositorySetExpectation;
use LaraStrict\Testing\Laravel\Contracts\Cache\RepositorySetMultipleExpectation;
use PHPUnit\Framework\TestCase;

class RepositoryAssertTest extends TestCase
{
    use AssertExpectations;

    protected function generateData(): array
    {
        $store = new NullStore();
        return [
            new AssertExpectationEntity(
                methodName: 'pull',
                createAssert: static fn () => new RepositoryAssert(pull: [
                    new RepositoryPullExpectation(return: 'Test', key: '123', default: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->pull(key: '123', default: 'Rock'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'pull',
                createAssert: static fn () => new RepositoryAssert(pull: [
                    new RepositoryPullExpectation(return: 'Test', key: '123'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->pull(key: '123'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'put',
                createAssert: static fn () => new RepositoryAssert(put: [
                    new RepositoryPutExpectation(return: 'Test', key: '123', value: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->put(key: '123', value: 'Rock'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'put',
                createAssert: static fn () => new RepositoryAssert(put: [
                    new RepositoryPutExpectation(return: 'Test', key: '123', value: 'Rock', ttl: 123),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->put(key: '123', value: 'Rock', ttl: 123),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'add',
                createAssert: static fn () => new RepositoryAssert(add: [
                    new RepositoryAddExpectation(return: 'Test', key: '123', value: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->add(key: '123', value: 'Rock'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'add',
                createAssert: static fn () => new RepositoryAssert(add: [
                    new RepositoryAddExpectation(return: 'Test', key: '123', value: 'Rock', ttl: 123),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->add(key: '123', value: 'Rock', ttl: 123),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'increment',
                createAssert: static fn () => new RepositoryAssert(increment: [
                    new RepositoryIncrementExpectation(return: true, key: '123'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->increment(key: '123'),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'increment',
                createAssert: static fn () => new RepositoryAssert(increment: [
                    new RepositoryIncrementExpectation(return: false, key: '123', value: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->increment(key: '123', value: 'Rock'),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'decrement',
                createAssert: static fn () => new RepositoryAssert(decrement: [
                    new RepositoryDecrementExpectation(return: true, key: '123'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->decrement(key: '123'),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'decrement',
                createAssert: static fn () => new RepositoryAssert(decrement: [
                    new RepositoryDecrementExpectation(return: false, key: '123', value: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->decrement(key: '123', value: 'Rock'),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'forever',
                createAssert: static fn () => new RepositoryAssert(forever: [
                    new RepositoryForeverExpectation(return: 'Test', key: '123', value: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->forever(key: '123', value: 'Rock'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'remember',
                createAssert: static fn () => new RepositoryAssert(remember: [
                    new RepositoryRememberExpectation(
                        return: 'Test',
                        key: '123',
                        ttl: 1234,
                        hook: static fn ($key, $ttl, $callback, $expectation) => self::assertEquals('Rock', $callback())
                    ),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->remember(
                    key: '123',
                    ttl: 1234,
                    callback: static fn () => 'Rock'
                ),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'sear',
                createAssert: static fn () => new RepositoryAssert(sear: [
                    new RepositorySearExpectation(
                        return: 'Test',
                        key: '123',
                        hook: static fn ($key, $callback, $expectation) => self::assertEquals('Rock', $callback())
                    ),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->sear(
                    key: '123',
                    callback: static fn () => 'Rock'
                ),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'rememberForever',
                createAssert: static fn () => new RepositoryAssert(rememberForever: [
                    new RepositoryRememberForeverExpectation(
                        return: 'Test',
                        key: '123',
                        hook: static fn ($key, $callback, $expectation) => self::assertEquals('Rock', $callback())
                    ),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->rememberForever(
                    key: '123',
                    callback: static fn () => 'Rock'
                ),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'forget',
                createAssert: static fn () => new RepositoryAssert(forget: [
                    new RepositoryForgetExpectation(return: 'Test', key: '123'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->forget(key: '123'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'getStore',
                createAssert: static fn () => new RepositoryAssert(getStore: [
                    new RepositoryGetStoreExpectation(return: $store),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->getStore(),
                checkResult: true,
                expectedResult: $store
            ),
            new AssertExpectationEntity(
                methodName: 'get',
                createAssert: static fn () => new RepositoryAssert(get: [
                    new RepositoryGetExpectation(return: 'Test', key: '123'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->get(key: '123'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'get',
                createAssert: static fn () => new RepositoryAssert(get: [
                    new RepositoryGetExpectation(return: 'Test', key: '123', default: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->get(key: '123', default: 'Rock'),
                checkResult: true,
                expectedResult: 'Test'
            ),
            new AssertExpectationEntity(
                methodName: 'set',
                createAssert: static fn () => new RepositoryAssert(set: [
                    new RepositorySetExpectation(return: true, key: '123', value: 'Rock', ttl: 1234),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->set(key: '123', value: 'Rock', ttl: 1234),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'set',
                createAssert: static fn () => new RepositoryAssert(set: [
                    new RepositorySetExpectation(return: true, key: '123', value: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->set(key: '123', value: 'Rock'),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'delete',
                createAssert: static fn () => new RepositoryAssert(delete: [
                    new RepositoryDeleteExpectation(return: true, key: '123'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->delete(key: '123'),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'clear',
                createAssert: static fn () => new RepositoryAssert(clear: [
                    new RepositoryClearExpectation(return: true),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->clear(),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'getMultiple',
                createAssert: static fn () => new RepositoryAssert(getMultiple: [
                    new RepositoryGetMultipleExpectation(return: [], keys: ['123'], default: 'Rock'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->getMultiple(keys: ['123'], default: 'Rock'),
                checkResult: true,
                expectedResult: []
            ),
            new AssertExpectationEntity(
                methodName: 'getMultiple',
                createAssert: static fn () => new RepositoryAssert(getMultiple: [
                    new RepositoryGetMultipleExpectation(return: ['1'], keys: ['1234']),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->getMultiple(keys: ['1234']),
                checkResult: true,
                expectedResult: ['1']
            ),
            new AssertExpectationEntity(
                methodName: 'setMultiple',
                createAssert: static fn () => new RepositoryAssert(setMultiple: [
                    new RepositorySetMultipleExpectation(return: true, values: ['123'], ttl: 123),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->setMultiple(values: ['123'], ttl: 123),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'setMultiple',
                createAssert: static fn () => new RepositoryAssert(setMultiple: [
                    new RepositorySetMultipleExpectation(return: false, values: ['1234']),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->setMultiple(values: ['1234']),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'deleteMultiple',
                createAssert: static fn () => new RepositoryAssert(deleteMultiple: [
                    new RepositoryDeleteMultipleExpectation(return: false, keys: ['1234']),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->deleteMultiple(keys: ['1234']),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'has',
                createAssert: static fn () => new RepositoryAssert(has: [
                    new RepositoryHasExpectation(return: false, key: '123'),
                ]),
                call: static fn (RepositoryAssert $assert) => $assert->has(key: '123'),
                checkResult: true,
                expectedResult: false
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new RepositoryAssert();
    }
}
