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
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Console\Input\ArrayInput;
use Tests\LaraStrict\Feature\Queue\Actions\TestCommand;
use Tests\LaraStrict\Feature\Queue\Actions\WithoutCommandJob;
use Tests\LaraStrict\Feature\TestCase;

final class RunOrQueueJobActionTest extends TestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataNoCommand(): array
    {
        $job = new WithoutCommandJob('Test');

        return [
            'dispatches job' => [
                static fn () => Assert::assertEquals(
                    null,
                    self::makeAction(
                        true,
                        false,
                        null,
                        $job,
                    )->execute($job),
                ),
            ],
            'setupBeforeRun passed but not used, dispatches job' => [
                static fn () => Assert::assertEquals(
                    null,
                    self::makeAction(
                        true,
                        false,
                        null,
                        $job,
                    )->execute($job, null, static function (Job $job): never {
                        Assert::fail('setupBeforeRun should not be called');
                    }),
                ),
            ],
            '$shouldQueue=true does nothing, dispatches job' => [
                static fn () => Assert::assertEquals(
                    null,
                    self::makeAction(
                        true,
                        false,
                        null,
                        $job,
                    )->execute($job, null, null, true),
                ),
            ],
            '$shouldQueue=false forces the job tu run' => [
                static fn () => Assert::assertEquals(
                    'Test',
                    self::makeAction(
                        false,
                        true,
                        null,
                        $job,
                    )->execute($job, null, null, false),
                ),
            ],
            '$shouldQueue=false forces the job tu run, setupBeforeRun called' => [static function () use ($job) {
                $setupBeforeRunCalled = false;
                Assert::assertEquals(
                    'Test',
                    self::makeAction(
                        false,
                        true,
                        null,
                        $job,
                    )->execute($job, null, static function (Job $givenJob) use ($job, &$setupBeforeRunCalled) {
                        Assert::assertSame($job, $givenJob, 'Job should be same');
                        $setupBeforeRunCalled = true;
                    }, false),
                );
                Assert::assertTrue($setupBeforeRunCalled, 'setupBeforeRun should be triggered');
            }],
        ];
    }

    /**
     * @param Closure():void $assert
     */
    #[DataProvider('dataNoCommand')]
    public function testNoCommand(Closure $assert): void
    {
        $assert();
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataWithCommand(): array
    {
        $job = new WithoutCommandJob('Test');
        $command = self::makeCommand([]);

        return [
            'queue not set, runs the job' => [
                static fn () => Assert::assertEquals(
                    'Test',
                    self::makeAction(
                        false,
                        true,
                        $command,
                        $job,
                    )->execute($job, $command),
                ),
            ],
            '$shouldQueue=true forces to dispatches job' => [
                static fn () => Assert::assertEquals(
                    null,
                    self::makeAction(
                        true,
                        false,
                        $command,
                        $job,
                    )->execute($job, $command, null, true),
                ),
            ],
            '$shouldQueue=false does nothing, runs the job' => [
                static fn () => Assert::assertEquals(
                    'Test',
                    self::makeAction(
                        false,
                        true,
                        $command,
                        $job,
                    )->execute($job, $command, null, false),
                ),
            ],
            '$shouldQueue=false forces the job tu run, setupBeforeRun called' => [static function () use (
                $job,
                $command
            ) {
                $setupBeforeRunCalled = false;
                Assert::assertEquals(
                    'Test',
                    self::makeAction(
                        false,
                        true,
                        $command,
                        $job,
                    )->execute(
                        $job,
                        $command,
                        static function (Job $givenJob) use ($job, &$setupBeforeRunCalled) {
                            Assert::assertSame($job, $givenJob, 'Job should be same');
                            $setupBeforeRunCalled = true;
                        },
                        false,
                    ),
                );
                Assert::assertTrue($setupBeforeRunCalled, 'setupBeforeRun should be triggered');
            }],
        ];
    }

    /**
     * @param Closure():void $assert
     */
    #[DataProvider('dataWithCommand')]
    public function testWithCommand(Closure $assert): void
    {
        $assert();
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataWithCommandAndQueue(): array
    {
        $job = new WithoutCommandJob('Test');
        $command = self::makeCommand([
            '--queue' => true,
        ]);

        return [
            'queue set, dispatches the queue' => [
                static fn () => Assert::assertEquals(
                    null,
                    self::makeAction(
                        true,
                        false,
                        $command,
                        $job,
                    )->execute($job, $command),
                ),
            ],
            '$shouldQueue=true forces to dispatches job' => [
                static fn () => Assert::assertEquals(
                    null,
                    self::makeAction(
                        true,
                        false,
                        $command,
                        $job,
                    )->execute($job, $command, null, true),
                ),
            ],
            '$shouldQueue=false does nothing, runs the job' => [
                static fn () => Assert::assertEquals(
                    'Test',
                    self::makeAction(
                        false,
                        true,
                        $command,
                        $job,
                    )->execute($job, $command, null, false),
                ),
            ],
            '$shouldQueue=false forces the job tu run, setupBeforeRun called' => [static function () use (
                $job,
                $command
            ) {
                $setupBeforeRunCalled = false;
                Assert::assertEquals(
                    'Test',
                    self::makeAction(
                        false,
                        true,
                        $command,
                        $job,
                    )->execute(
                        $job,
                        $command,
                        static function (Job $givenJob) use ($job, &$setupBeforeRunCalled) {
                            Assert::assertSame($job, $givenJob, 'Job should be same');
                            $setupBeforeRunCalled = true;
                        },
                        false,
                    ),
                );
                Assert::assertTrue($setupBeforeRunCalled, 'setupBeforeRun should be triggered');
            }],
        ];
    }

    /**
     * @param Closure():void $assert
     */
    #[DataProvider('dataWithCommandAndQueue')]
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
            new RunJobActionContractAssert([
                $expectedRunJob === false ? null : new RunJobActionContractExpectation(
                    'Test',
                    $job,
                    $expectedCommand,
                ),
            ]),
            new DispatchJobActionContractAssert([
                $expectedDispatchJob === false ? null : new DispatchJobActionContractExpectation(
                    true,
                    $job,
                ),
            ]),
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
