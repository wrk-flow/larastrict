<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\Bus;

use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\Bus\DispatcherAssert;
use LaraStrict\Testing\Laravel\Contracts\Bus\DispatcherDispatchExpectation;
use LaraStrict\Testing\Laravel\Contracts\Bus\DispatcherDispatchNowExpectation;
use LaraStrict\Testing\Laravel\Contracts\Bus\DispatcherDispatchSyncExpectation;
use LaraStrict\Testing\Laravel\Contracts\Bus\DispatcherGetCommandHandlerExpectation;
use LaraStrict\Testing\Laravel\Contracts\Bus\DispatcherHasCommandHandlerExpectation;
use LaraStrict\Testing\Laravel\Contracts\Bus\DispatcherMapExpectation;
use LaraStrict\Testing\Laravel\Contracts\Bus\DispatcherPipeThroughExpectation;
use PHPUnit\Framework\TestCase;

class DispatcherAssertTest extends TestCase
{
    use AssertExpectations;

    protected static function generateData(): array
    {
        $testJob = new TestJob();
        return [
            new AssertExpectationEntity(
                methodName: 'dispatch',
                createAssert: static fn () => new DispatcherAssert(
                    dispatch: [new DispatcherDispatchExpectation(return: [], command: $testJob)],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->dispatch(command: $testJob),
                checkResult: true,
                expectedResult: [],
            ),
            new AssertExpectationEntity(
                methodName: 'dispatch',
                createAssert: static fn () => new DispatcherAssert(
                    dispatch: [new DispatcherDispatchExpectation(return: null, command: $testJob)],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->dispatch(command: $testJob),
                checkResult: true,
                expectedResult: null,
            ),
            new AssertExpectationEntity(
                methodName: 'dispatchSync',
                createAssert: static fn () => new DispatcherAssert(
                    dispatchSync: [new DispatcherDispatchSyncExpectation(return: [], command: $testJob)],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->dispatchSync(command: $testJob),
                checkResult: true,
                expectedResult: [],
            ),
            new AssertExpectationEntity(
                methodName: 'dispatchSync',
                createAssert: static fn () => new DispatcherAssert(
                    dispatchSync: [new DispatcherDispatchSyncExpectation(return: null, command: $testJob)],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->dispatchSync(command: $testJob),
                checkResult: true,
                expectedResult: null,
            ),
            new AssertExpectationEntity(
                methodName: 'dispatchNow',
                createAssert: static fn () => new DispatcherAssert(
                    dispatchNow: [new DispatcherDispatchNowExpectation(return: [], command: $testJob)],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->dispatchNow(command: $testJob),
                checkResult: true,
                expectedResult: [],
            ),
            new AssertExpectationEntity(
                methodName: 'dispatchNow',
                createAssert: static fn () => new DispatcherAssert(
                    dispatchNow: [new DispatcherDispatchNowExpectation(return: null, command: $testJob)],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->dispatchNow(command: $testJob),
                checkResult: true,
                expectedResult: null,
            ),
            new AssertExpectationEntity(
                methodName: 'hasCommandHandler',
                createAssert: static fn () => new DispatcherAssert(
                    hasCommandHandler: [
                        new DispatcherHasCommandHandlerExpectation(return: true, command: $testJob),
                    ],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->hasCommandHandler(command: $testJob),
                checkResult: true,
                expectedResult: true,
            ),
            new AssertExpectationEntity(
                methodName: 'hasCommandHandler',
                createAssert: static fn () => new DispatcherAssert(
                    hasCommandHandler: [
                        new DispatcherHasCommandHandlerExpectation(return: false, command: $testJob),
                    ],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->hasCommandHandler(command: $testJob),
                checkResult: true,
                expectedResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'getCommandHandler',
                createAssert: static fn () => new DispatcherAssert(
                    getCommandHandler: [
                        new DispatcherGetCommandHandlerExpectation(return: $testJob, command: $testJob),
                    ],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->getCommandHandler(command: $testJob),
                checkResult: true,
                expectedResult: $testJob,
            ),
            new AssertExpectationEntity(
                methodName: 'getCommandHandler',
                createAssert: static fn () => new DispatcherAssert(
                    getCommandHandler: [
                        new DispatcherGetCommandHandlerExpectation(return: false, command: $testJob),
                    ],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->getCommandHandler(command: $testJob),
                checkResult: true,
                expectedResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'pipeThrough',
                createAssert: static fn () => new DispatcherAssert(
                    pipeThrough: [new DispatcherPipeThroughExpectation(pipes: [TestJob::class])],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->pipeThrough(pipes: [TestJob::class]),
                checkResult: true,
                checkResultIsSelf: true,
            ),
            new AssertExpectationEntity(
                methodName: 'map',
                createAssert: static fn () => new DispatcherAssert(
                    map: [new DispatcherMapExpectation(map: [TestJob::class])],
                ),
                call: static fn (DispatcherAssert $assert) => $assert->map(map: [TestJob::class]),
                checkResult: true,
                checkResultIsSelf: true,
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new DispatcherAssert();
    }
}
