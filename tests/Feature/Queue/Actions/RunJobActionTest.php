<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Queue\Actions;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Actions\RunJobAction;
use LaraStrict\Queue\Exceptions\MethodInJobIsNotDefinedException;
use LaraStrict\Queue\Jobs\Job;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LaraStrict\Feature\TestCase;

/**
 * @phpstan-type AssertClosure Closure(static,Job,string|Command):void
 */
final class RunJobActionTest extends TestCase
{
    private RunJobAction $runJobAction;

    private Command $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->runJobAction = $this->make(RunJobAction::class);
        $this->command = new Command();
    }

    /**
     * @return array<string|int, array{0: AssertClosure}>
     */
    public static function data(): array
    {
        return [
            'with command' => [
                static fn (self $self, Job $job, string|Command $expectedResult) => Assert::assertEquals(
                    expected: $expectedResult,
                    actual: $self->runJobAction->execute(job: $job, command: $self->command),
                ),
            ],
            'with command, handle method' => [
                static fn (self $self, Job $job, string|Command $expectedResult) => Assert::assertEquals(
                    expected: $expectedResult,
                    actual: $self->runJobAction->execute(job: $job, command: $self->command, method: 'handle'),
                ),
            ],
            'without command' => [
                static fn (self $self, Job $job, string|Command $expectedResult) => Assert::assertEquals(
                    // When command is not passed, null is expected
                    expected: $expectedResult === $self->command ? null : $expectedResult,
                    actual: $self->runJobAction->execute(job: $job),
                ),
            ],
            'without command, handle method' => [
                static fn (self $self, Job $job, string|Command $expectedResult) => Assert::assertEquals(
                    expected: $expectedResult === $self->command ? null : $expectedResult,
                    actual: $self->runJobAction->execute(job: $job, method: 'handle'),
                ),
            ],
        ];
    }

    /**
     * @param AssertClosure $assert
     */
    #[DataProvider('data')]
    public function testWithoutCommandJob(Closure $assert): void
    {
        $assert($this, new WithoutCommandJob('hello world!'), 'hello world!');
    }

    public function testWithoutCommandJobNonExistingMethod(): void
    {
        $this->expectException(MethodInJobIsNotDefinedException::class);
        $this->expectExceptionMessage(sprintf(
            'Given job <%s> does not contain desired method <%s>',
            WithoutCommandJob::class,
            'handleJob'
        ));
        $this->runJobAction->execute(job: new WithoutCommandJob('hello world!'), method: 'handleJob');
    }

    /**
     * @param AssertClosure $assert
     */
    #[DataProvider('data')]
    public function testCommandJob(Closure $assert): void
    {
        $assert($this, new CommandJob(), $this->command);
    }
}
