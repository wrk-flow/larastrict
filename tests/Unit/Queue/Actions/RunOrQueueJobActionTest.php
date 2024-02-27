<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Queue\Actions;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Actions\RunOrQueueJobAction;
use LaraStrict\Queue\Jobs\Job;
use LaraStrict\Testing\Queue\Contracts\DispatchJobActionContractAssert;
use LaraStrict\Testing\Queue\Contracts\DispatchJobActionContractExpectation;
use LaraStrict\Testing\Queue\Contracts\RunJobActionContractAssert;
use LaraStrict\Testing\Queue\Contracts\RunJobActionContractExpectation;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Input\ArrayInput;
use Tests\LaraStrict\Feature\Queue\Actions\TestCommand;
use Tests\LaraStrict\Feature\Queue\Actions\WithoutCommandJob;
use Tests\LaraStrict\Feature\TestCase;

final class RunOrQueueJobActionTest extends TestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataNoCommand(): array
    {
        $job = new WithoutCommandJob('Test');

        return [
            'dispatches job' => [
                static fn () => Assert::assertEquals(
                    expected: null,
                    actual: self::makeAction(
                        expectedDispatchJob: true,
                        expectedRunJob: false,
                        expectedCommand: null,
                        job: $job,
                    )->execute(job: $job),
                ),
            ],
            'setupBeforeRun passed but not used, dispatches job' => [
                static fn () => Assert::assertEquals(
                    expected: null,
                    actual: self::makeAction(
                        expectedDispatchJob: true,
                        expectedRunJob: false,
                        expectedCommand: null,
                        job: $job,
                    )->execute(job: $job, setupBeforeRun: static function (Job $job): never {
                        Assert::fail('setupBeforeRun should not be called');
                    }),
                ),
            ],
            '$shouldQueue=true does nothing, dispatches job' => [
                static fn () => Assert::assertEquals(
                    expected: null,
                    actual: self::makeAction(
                        expectedDispatchJob: true,
                        expectedRunJob: false,
                        expectedCommand: null,
                        job: $job,
                    )->execute(job: $job, shouldQueue: true),
                ),
            ],
            '$shouldQueue=false forces the job tu run' => [
                static fn () => Assert::assertEquals(
                    expected: 'Test',
                    actual: self::makeAction(
                        expectedDispatchJob: false,
                        expectedRunJob: true,
                        expectedCommand: null,
                        job: $job,
                    )->execute(job: $job, shouldQueue: false),
                ),
            ],
            '$shouldQueue=false forces the job tu run, setupBeforeRun called' => [static function () use ($job) {
                $setupBeforeRunCalled = false;
                Assert::assertEquals(
                    expected: 'Test',
                    actual: self::makeAction(
                        expectedDispatchJob: false,
                        expectedRunJob: true,
                        expectedCommand: null,
                        job: $job,
                    )->execute(
                        job: $job,
                        setupBeforeRun: static function (Job $givenJob) use ($job, &$setupBeforeRunCalled) {
                            Assert::assertSame($job, $givenJob, 'Job should be same');
                            $setupBeforeRunCalled = true;
                        },
                        shouldQueue: false
                    ),
                );
                Assert::assertTrue($setupBeforeRunCalled, 'setupBeforeRun should be trigered');
            }],
        ];
    }

    /**
     * @param Closure():void $assert
     *
     * @dataProvider dataNoCommand
     */
    public function testNoCommand(Closure $assert): void
    {
        $assert();
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataWithCommand(): array
    {
        $job = new WithoutCommandJob('Test');
        $command = $this->makeCommand([]);

        return [
            'queue not set, runs the job' => [
                static fn () => Assert::assertEquals(
                    expected: 'Test',
                    actual: self::makeAction(
                        expectedDispatchJob: false,
                        expectedRunJob: true,
                        expectedCommand: $command,
                        job: $job,
                    )->execute(job: $job, command: $command),
                ),
            ],
            '$shouldQueue=true forces to dispatches job' => [
                static fn () => Assert::assertEquals(
                    expected: null,
                    actual: self::makeAction(
                        expectedDispatchJob: true,
                        expectedRunJob: false,
                        expectedCommand: $command,
                        job: $job,
                    )->execute(job: $job, shouldQueue: true, command: $command),
                ),
            ],
            '$shouldQueue=false does nothing, runs the job' => [
                static fn () => Assert::assertEquals(
                    expected: 'Test',
                    actual: self::makeAction(
                        expectedDispatchJob: false,
                        expectedRunJob: true,
                        expectedCommand: $command,
                        job: $job,
                    )->execute(job: $job, shouldQueue: false, command: $command),
                ),
            ],
            '$shouldQueue=false forces the job tu run, setupBeforeRun called' => [static function () use (
                $job,
                $command
            ) {
                $setupBeforeRunCalled = false;
                Assert::assertEquals(
                    expected: 'Test',
                    actual: self::makeAction(
                        expectedDispatchJob: false,
                        expectedRunJob: true,
                        expectedCommand: $command,
                        job: $job,
                    )->execute(
                        job: $job,
                        command: $command,
                        setupBeforeRun: static function (Job $givenJob) use ($job, &$setupBeforeRunCalled) {
                            Assert::assertSame($job, $givenJob, 'Job should be same');
                            $setupBeforeRunCalled = true;
                        },
                        shouldQueue: false
                    ),
                );
                Assert::assertTrue($setupBeforeRunCalled, 'setupBeforeRun should be trigered');
            }],
        ];
    }

    /**
     * @param Closure():void $assert
     *
     * @dataProvider dataWithCommand
     */
    public function testWithCommand(Closure $assert): void
    {
        $assert();
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataWithCommandAndQueue(): array
    {
        $job = new WithoutCommandJob('Test');
        $command = $this->makeCommand([
            '--queue' => true,
        ]);

        return [
            'queue set, dispatches the queue' => [
                static fn () => Assert::assertEquals(
                    expected: null,
                    actual: self::makeAction(
                        expectedDispatchJob: true,
                        expectedRunJob: false,
                        expectedCommand: $command,
                        job: $job,
                    )->execute(job: $job, command: $command),
                ),
            ],
            '$shouldQueue=true forces to dispatches job' => [
                static fn () => Assert::assertEquals(
                    expected: null,
                    actual: self::makeAction(
                        expectedDispatchJob: true,
                        expectedRunJob: false,
                        expectedCommand: $command,
                        job: $job,
                    )->execute(job: $job, shouldQueue: true, command: $command),
                ),
            ],
            '$shouldQueue=false does nothing, runs the job' => [
                static fn () => Assert::assertEquals(
                    expected: 'Test',
                    actual: self::makeAction(
                        expectedDispatchJob: false,
                        expectedRunJob: true,
                        expectedCommand: $command,
                        job: $job,
                    )->execute(job: $job, shouldQueue: false, command: $command),
                ),
            ],
            '$shouldQueue=false forces the job tu run, setupBeforeRun called' => [static function () use (
                $job,
                $command
            ) {
                $setupBeforeRunCalled = false;
                Assert::assertEquals(
                    expected: 'Test',
                    actual: self::makeAction(
                        expectedDispatchJob: false,
                        expectedRunJob: true,
                        expectedCommand: $command,
                        job: $job,
                    )->execute(
                        job: $job,
                        command: $command,
                        setupBeforeRun: static function (Job $givenJob) use ($job, &$setupBeforeRunCalled) {
                            Assert::assertSame($job, $givenJob, 'Job should be same');
                            $setupBeforeRunCalled = true;
                        },
                        shouldQueue: false
                    ),
                );
                Assert::assertTrue($setupBeforeRunCalled, 'setupBeforeRun should be trigered');
            }],
        ];
    }

    /**
     * @param Closure():void $assert
     *
     * @dataProvider dataWithCommandAndQueue
     */
    public function testWithCommandAndQueue(Closure $assert): void
    {
        $assert();
    }

    protected static function makeAction(
        bool $expectedDispatchJob,
        bool $expectedRunJob,
        ?Command $expectedCommand,
        Job $job,
    ): RunOrQueueJobAction {
        return new RunOrQueueJobAction(
            runJobAction: new RunJobActionContractAssert([
                $expectedRunJob === false ? null : new RunJobActionContractExpectation(
                    return: 'Test',
                    job: $job,
                    command: $expectedCommand,
                ),
            ]),
            dispatchJobAction: new DispatchJobActionContractAssert([
                $expectedDispatchJob === false ? null : new DispatchJobActionContractExpectation(
                    return: true,
                    job: $job,
                ),
            ])
        );
    }

    /**
     * @param array<string, mixed> $params
     */
    protected static function makeCommand(array $params): Command
    {
        $command = new TestCommand();
        $definition = $command->getDefinition();
        $command->setInput(new ArrayInput($params, $definition));

        return $command;
    }
}
