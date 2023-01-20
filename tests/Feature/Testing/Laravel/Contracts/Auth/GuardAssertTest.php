<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\Auth;

use Illuminate\Foundation\Auth\User;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\Auth\GuardAssert;
use LaraStrict\Testing\Laravel\Contracts\Auth\GuardCheckExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\GuardGuestExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\GuardHasUserExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\GuardIdExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\GuardSetUserExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\GuardUserExpectation;
use LaraStrict\Testing\Laravel\Contracts\Auth\GuardValidateExpectation;
use PHPUnit\Framework\TestCase;

class GuardAssertTest extends TestCase
{
    use AssertExpectations;

    protected function generateData(): array
    {
        $user = new User();
        return [
            new AssertExpectationEntity(
                methodName: 'check',
                createAssert: static fn () => new GuardAssert(check: [new GuardCheckExpectation(return: false)]),
                call: static fn (GuardAssert $asser) => $asser->check(),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'check',
                createAssert: static fn () => new GuardAssert(check: [new GuardCheckExpectation(return: true)]),
                call: static fn (GuardAssert $asser) => $asser->check(),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'guest',
                createAssert: static fn () => new GuardAssert(guest: [new GuardGuestExpectation(return: false)]),
                call: static fn (GuardAssert $asser) => $asser->guest(),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'guest',
                createAssert: static fn () => new GuardAssert(guest: [new GuardGuestExpectation(return: true)]),
                call: static fn (GuardAssert $asser) => $asser->guest(),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'user',
                createAssert: static fn () => new GuardAssert(user: [new GuardUserExpectation(return: $user)]),
                call: static fn (GuardAssert $asser) => $asser->user(),
                checkResult: true,
                expectedResult: $user
            ),
            new AssertExpectationEntity(
                methodName: 'user',
                createAssert: static fn () => new GuardAssert(user: [new GuardUserExpectation(return: null)]),
                call: static fn (GuardAssert $asser) => $asser->user(),
                checkResult: true,
                expectedResult: null
            ),
            new AssertExpectationEntity(
                methodName: 'id',
                createAssert: static fn () => new GuardAssert(id: [new GuardIdExpectation(return: 1)]),
                call: static fn (GuardAssert $asser) => $asser->id(),
                checkResult: true,
                expectedResult: 1
            ),
            new AssertExpectationEntity(
                methodName: 'validate',
                createAssert: static fn () => new GuardAssert(validate: [new GuardValidateExpectation(return: 1)]),
                call: static fn (GuardAssert $asser) => $asser->validate(),
                checkResult: true,
                expectedResult: 1
            ),
            new AssertExpectationEntity(
                methodName: 'validate',
                createAssert: static fn () => new GuardAssert(validate: [
                    new GuardValidateExpectation(return: true, credentials: ['s']),
                ]),
                call: static fn (GuardAssert $asser) => $asser->validate(credentials: ['s']),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'hasUser',
                createAssert: static fn () => new GuardAssert(hasUser: [
                    new GuardHasUserExpectation(return: false),
                ]),
                call: static fn (GuardAssert $asser) => $asser->hasUser(),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'hasUser',
                createAssert: static fn () => new GuardAssert(hasUser: [new GuardHasUserExpectation(return: true)]),
                call: static fn (GuardAssert $asser) => $asser->hasUser(),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'setUser',
                createAssert: static fn () => new GuardAssert(setUser: [new GuardSetUserExpectation(user: $user)]),
                call: static fn (GuardAssert $asser) => $asser->setUser($user),
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new GuardAssert();
    }
}
