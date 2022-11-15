<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Contracts\Auth\Access;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateAbilitiesExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateAfterExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateAllowsExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateAnyExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateAssert;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateAuthorizeExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateBeforeExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateCheckExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateDefineExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateDeniesExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateForUserExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateGetPolicyForExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateHasExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateInspectExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GatePolicyExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateRawExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\Access\GateResourceExpectation;
use LogicException;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Providers\Pipes\RegisterProviderPoliciesPipe\TestPolicy;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestAction;

class GateAssertTest extends TestCase
{
    /**
     * @dataProvider data
     */
    public function testEmpty(GateAssertExpectationEntity $expectation): void
    {
        $this->assertBadCall($expectation->methodName);
        $assert = new GateAssert();

        $this->callExpectation($expectation, $assert);
    }

    /**
     * @dataProvider data
     */
    public function testCallsWithSecondFails(GateAssertExpectationEntity $expectation): void
    {
        /** @var GateAssert $assert */
        $assert = call_user_func($expectation->createAssert, $expectation->createAssert);

        $this->assertSame($expectation->expectedResult ?? $assert, $this->callExpectation($expectation, $assert));

        $this->assertBadCall(method: $expectation->methodName, callNumber: 2);
        $this->callExpectation($expectation, $assert);
    }

    public function data(): array
    {
        $authorizeResponse = new Response(true);

        $callback = static function () {
        };
        $testPolicy = new TestPolicy();
        $user = new User();
        $tests = [
            new GateAssertExpectationEntity(
                methodName: 'has',
                createAssert: static fn () => new GateAssert(has: [new GateHasExpectation(
                    return: false,
                    ability: 's',
                )]),
                call: static fn (GateAssert $assert) => $assert->has('s'),
                expectedResult: false,
            ),
            new GateAssertExpectationEntity(
                methodName: 'define',
                createAssert: static fn () => new GateAssert(define: [new GateDefineExpectation(
                    ability: 's',
                    callback: 'test',
                )]),
                call: static fn (GateAssert $assert) => $assert->define('s', 'test'),
                expectedResult: null,
            ),
            new GateAssertExpectationEntity(
                methodName: 'resource',
                createAssert: static fn () => new GateAssert(resource: [new GateResourceExpectation(
                    name: 'test',
                    class: TestAction::class,
                    abilities: ['asd'],
                )]),
                call: static fn (GateAssert $assert) => $assert->resource('test', TestAction::class, ['asd']),
                expectedResult: null,
            ),
            new GateAssertExpectationEntity(
                methodName: 'policy',
                createAssert: static fn () => new GateAssert(policy: [new GatePolicyExpectation(
                    class: TestPolicy::class,
                    policy: 'testPolicy',
                )]),
                call: static fn (GateAssert $assert) => $assert->policy(TestPolicy::class, 'testPolicy'),
                expectedResult: null,
            ),
            new GateAssertExpectationEntity(
                methodName: 'before',
                createAssert: static fn () => new GateAssert(before: [new GateBeforeExpectation(
                    callback: $callback
                )]),
                call: static fn (GateAssert $assert) => $assert->before($callback),
                expectedResult: null,
            ),
            new GateAssertExpectationEntity(
                methodName: 'after',
                createAssert: static fn () => new GateAssert(after: [new GateAfterExpectation(
                    callback: $callback
                )]),
                call: static fn (GateAssert $assert) => $assert->after($callback),
                expectedResult: null,
            ),
            new GateAssertExpectationEntity(
                methodName: 'allows',
                createAssert: static fn () => new GateAssert(allows: [new GateAllowsExpectation(
                    return: true,
                    ability: 'test',
                    arguments: ['test']
                )]),
                call: static fn (GateAssert $assert) => $assert->allows('test', ['test']),
                expectedResult: true,
            ),
            new GateAssertExpectationEntity(
                methodName: 'denies',
                createAssert: static fn () => new GateAssert(denies: [new GateDeniesExpectation(
                    return: false,
                    ability: 'test',
                    arguments: ['test']
                )]),
                call: static fn (GateAssert $assert) => $assert->denies('test', ['test']),
                expectedResult: false,
            ),
            new GateAssertExpectationEntity(
                methodName: 'check',
                createAssert: static fn () => new GateAssert(check: [new GateCheckExpectation(
                    return: true,
                    abilities: ['ability'],
                    arguments: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->check(['ability'], ['test']),
                expectedResult: true,
            ),
            new GateAssertExpectationEntity(
                methodName: 'any',
                createAssert: static fn () => new GateAssert(any: [new GateAnyExpectation(
                    return: true,
                    abilities: ['ability'],
                    arguments: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->any(['ability'], ['test']),
                expectedResult: true,
            ),
            new GateAssertExpectationEntity(
                methodName: 'authorize',
                createAssert: static fn () => new GateAssert(authorize: [new GateAuthorizeExpectation(
                    return: $authorizeResponse,
                    ability: 's',
                    arguments: ['test']
                )]),
                call: static fn (GateAssert $assert) => $assert->authorize('s', ['test']),
                expectedResult: $authorizeResponse,
            ),
            new GateAssertExpectationEntity(
                methodName: 'inspect',
                createAssert: static fn () => new GateAssert(inspect: [new GateInspectExpectation(
                    return: $authorizeResponse,
                    ability: 'ability',
                    arguments: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->inspect('ability', ['test']),
                expectedResult: $authorizeResponse,
            ),
            new GateAssertExpectationEntity(
                methodName: 'raw',
                createAssert: static fn () => new GateAssert(raw: [new GateRawExpectation(
                    return: $authorizeResponse,
                    ability: 'ability',
                    arguments: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->raw('ability', ['test']),
                expectedResult: $authorizeResponse,
            ),
            new GateAssertExpectationEntity(
                methodName: 'getPolicyFor',
                createAssert: static fn () => new GateAssert(getPolicyFor: [new GateGetPolicyForExpectation(
                    return: $testPolicy,
                    class: TestPolicy::class,
                )]),
                call: static fn (GateAssert $assert) => $assert->getPolicyFor(TestPolicy::class),
                expectedResult: $testPolicy,
            ),
            new GateAssertExpectationEntity(
                methodName: 'forUser',
                createAssert: static fn () => new GateAssert(forUser: [new GateForUserExpectation(user: $user,)]),
                call: static fn (GateAssert $assert) => $assert->forUser($user),
                expectedResult: null,
            ),
            new GateAssertExpectationEntity(
                methodName: 'abilities',
                createAssert: static fn () => new GateAssert(abilities: [new GateAbilitiesExpectation(
                    return: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->abilities(),
                expectedResult: ['test'],
            ),
        ];

        $data = [];
        foreach ($tests as $test) {
            $data[$test->methodName] = [$test];
        }

        return $data;
    }

    protected function assertBadCall(string $method, int $callNumber = 1): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage($method . '] not set for a n (' . $callNumber . ') call');
    }

    protected function callExpectation(GateAssertExpectationEntity $expectation, GateAssert $assert): mixed
    {
        return call_user_func($expectation->call, $assert);
    }
}
