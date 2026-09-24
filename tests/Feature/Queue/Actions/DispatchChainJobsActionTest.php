<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Queue\Actions;

use Closure;
use LaraStrict\Queue\Actions\DispatchChainJobsAction;
use LaraStrict\Testing\Queue\Contracts\DispatchJobActionContractAssert;
use LaraStrict\Testing\Queue\Contracts\DispatchJobActionContractExpectation;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class DispatchChainJobsActionTest extends TestCase
{
    public function testEmptyJobs(): void
    {
        $action = $this->makeAction(null);
        $this->assertFalse($action->execute([]));
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataOneJob(): array
    {
        return [
            'returns true on dispatch' => [
                static fn (self $self) => $self->assertOneJob(true),
            ],
            'returns false on dispatch' => [
                static fn (self $self) => $self->assertOneJob(false),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('dataOneJob')]
    public function testOneJob(Closure $assert): void
    {
        $assert($this);
    }

    public function assertOneJob(bool $expected): void
    {
        $job = new WithoutCommandJob('Hello');

        $action = $this->makeAction(new DispatchJobActionContractExpectation($expected, $job));

        Assert::assertEquals($expected, $action->execute([$job]));
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataChainJob(): array
    {
        return [
            'returns true on dispatch' => [
                static fn (self $self) => $self->assertChainJob(true),
            ],
            'returns false on dispatch' => [
                static fn (self $self) => $self->assertChainJob(false),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('dataChainJob')]
    public function testChainJob(Closure $assert): void
    {
        $assert($this);
    }

    public function assertChainJob(bool $expected): void
    {
        $job = new WithoutCommandJob('Hello');
        $job2 = new WithoutCommandJob('Hello2');

        $action = $this->makeAction(new DispatchJobActionContractExpectation($expected, $job));

        Assert::assertEquals($expected, $action->execute([$job, $job2]));

        Assert::assertEquals([serialize($job2)], $job->chained, 'Job should be changed');
        Assert::assertEquals('default', $job->chainQueue, 'Job should be changed');

        Assert::assertEmpty($job2->chained, 'Job2 should not be changed');
        Assert::assertNull($job2->chainQueue, 'Job2 should not be changed');
    }

    protected function makeAction(?DispatchJobActionContractExpectation $expectation): DispatchChainJobsAction
    {
        return new DispatchChainJobsAction(new DispatchJobActionContractAssert([$expectation]));
    }
}
