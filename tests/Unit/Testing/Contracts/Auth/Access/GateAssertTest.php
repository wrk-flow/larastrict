<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Contracts\Auth\Access;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
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
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Providers\Pipes\RegisterProviderPoliciesPipe\TestPolicy;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestAction;

class GateAssertTest extends TestCase
{
    use AssertExpectations;

    public function generateData(): array
    {
        $authorizeResponse = new Response(true);

        $callback = static function () {
        };
        $testPolicy = new TestPolicy();
        $user = new User();
        return [
            new AssertExpectationEntity(
                methodName: 'has',
                createAssert: static fn () => new GateAssert(has: [new GateHasExpectation(
                    return: false,
                    ability: 's',
                )]),
                call: static fn (GateAssert $assert) => $assert->has('s'),
                checkResult: true,
                expectedResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'define',
                createAssert: static fn () => new GateAssert(define: [new GateDefineExpectation(
                    ability: 's',
                    callback: 'test',
                )]),
                call: static fn (GateAssert $assert) => $assert->define('s', 'test'),
                checkResult: true,
                checkResultIsSelf: true,
            ),
            new AssertExpectationEntity(
                methodName: 'resource',
                createAssert: static fn () => new GateAssert(resource: [new GateResourceExpectation(
                    name: 'test',
                    class: TestAction::class,
                    abilities: ['asd'],
                )]),
                call: static fn (GateAssert $assert) => $assert->resource('test', TestAction::class, ['asd']),
                checkResult: true,
                checkResultIsSelf: true,
            ),
            new AssertExpectationEntity(
                methodName: 'policy',
                createAssert: static fn () => new GateAssert(policy: [new GatePolicyExpectation(
                    class: TestPolicy::class,
                    policy: 'testPolicy',
                )]),
                call: static fn (GateAssert $assert) => $assert->policy(TestPolicy::class, 'testPolicy'),
                checkResult: true,
                checkResultIsSelf: true,
            ),
            new AssertExpectationEntity(
                methodName: 'before',
                createAssert: static fn () => new GateAssert(before: [new GateBeforeExpectation(
                    callback: $callback
                )]),
                call: static fn (GateAssert $assert) => $assert->before($callback),
                checkResult: true,
                checkResultIsSelf: true,
            ),
            new AssertExpectationEntity(
                methodName: 'after',
                createAssert: static fn () => new GateAssert(after: [new GateAfterExpectation(
                    callback: $callback
                )]),
                call: static fn (GateAssert $assert) => $assert->after($callback),
                checkResult: true,
                checkResultIsSelf: true,
            ),
            new AssertExpectationEntity(
                methodName: 'allows',
                createAssert: static fn () => new GateAssert(allows: [new GateAllowsExpectation(
                    return: true,
                    ability: 'test',
                    arguments: ['test']
                )]),
                call: static fn (GateAssert $assert) => $assert->allows('test', ['test']),
                checkResult: true,
                expectedResult: true,
            ),
            new AssertExpectationEntity(
                methodName: 'denies',
                createAssert: static fn () => new GateAssert(denies: [new GateDeniesExpectation(
                    return: false,
                    ability: 'test',
                    arguments: ['test']
                )]),
                call: static fn (GateAssert $assert) => $assert->denies('test', ['test']),
                checkResult: true,
                expectedResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'check',
                createAssert: static fn () => new GateAssert(check: [new GateCheckExpectation(
                    return: true,
                    abilities: ['ability'],
                    arguments: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->check(['ability'], ['test']),
                checkResult: true,
                expectedResult: true,
            ),
            new AssertExpectationEntity(
                methodName: 'any',
                createAssert: static fn () => new GateAssert(any: [new GateAnyExpectation(
                    return: true,
                    abilities: ['ability'],
                    arguments: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->any(['ability'], ['test']),
                checkResult: true,
                expectedResult: true,
            ),
            new AssertExpectationEntity(
                methodName: 'authorize',
                createAssert: static fn () => new GateAssert(authorize: [new GateAuthorizeExpectation(
                    return: $authorizeResponse,
                    ability: 's',
                    arguments: ['test']
                )]),
                call: static fn (GateAssert $assert) => $assert->authorize('s', ['test']),
                checkResult: true,
                expectedResult: $authorizeResponse,
            ),
            new AssertExpectationEntity(
                methodName: 'inspect',
                createAssert: static fn () => new GateAssert(inspect: [new GateInspectExpectation(
                    return: $authorizeResponse,
                    ability: 'ability',
                    arguments: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->inspect('ability', ['test']),
                checkResult: true,
                expectedResult: $authorizeResponse,
            ),
            new AssertExpectationEntity(
                methodName: 'raw',
                createAssert: static fn () => new GateAssert(raw: [new GateRawExpectation(
                    return: $authorizeResponse,
                    ability: 'ability',
                    arguments: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->raw('ability', ['test']),
                checkResult: true,
                expectedResult: $authorizeResponse,
            ),
            new AssertExpectationEntity(
                methodName: 'getPolicyFor',
                createAssert: static fn () => new GateAssert(getPolicyFor: [new GateGetPolicyForExpectation(
                    return: $testPolicy,
                    class: TestPolicy::class,
                )]),
                call: static fn (GateAssert $assert) => $assert->getPolicyFor(TestPolicy::class),
                checkResult: true,
                expectedResult: $testPolicy,
            ),
            new AssertExpectationEntity(
                methodName: 'forUser',
                createAssert: static fn () => new GateAssert(forUser: [new GateForUserExpectation(user: $user)]),
                call: static fn (GateAssert $assert) => $assert->forUser($user),
                checkResult: true,
                checkResultIsSelf: true,
            ),
            new AssertExpectationEntity(
                methodName: 'abilities',
                createAssert: static fn () => new GateAssert(abilities: [new GateAbilitiesExpectation(
                    return: ['test'],
                )]),
                call: static fn (GateAssert $assert) => $assert->abilities(),
                checkResult: true,
                expectedResult: ['test'],
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new GateAssert();
    }
}
