<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Queue\Actions;

use Closure;
use LaraStrict\Queue\Actions\DispatchChainJobsAction;
use LaraStrict\Testing\Queue\Contracts\DispatchJobActionContractAssert;
use LaraStrict\Testing\Queue\Contracts\DispatchJobActionContractExpectation;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class DispatchChainJobsActionTest extends TestCase
{
    public function testEmptyJobs(): void
    {
        $action = $this->makeAction(expectation: null);
        $this->assertFalse($action->execute([]));
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataOneJob(): array
    {
        return [
            'returns true on dispatch' => [
                static fn (self $self) => $self->assertOneJob(expected: true),
            ],
            'returns false on dispatch' => [
                static fn (self $self) => $self->assertOneJob(expected: false),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     *
     * @dataProvider dataOneJob
     */
    public function testOneJob(Closure $assert): void
    {
        $assert($this);
    }

    public function assertOneJob(bool $expected): void
    {
        $job = new WithoutCommandJob(name: 'Hello');

        $action = $this->makeAction(new DispatchJobActionContractExpectation(return: $expected, job: $job));

        Assert::assertEquals(expected: $expected, actual: $action->execute([$job]));
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataChainJob(): array
    {
        return [
            'returns true on dispatch' => [
                static fn (self $self) => $self->assertChainJob(expected: true),
            ],
            'returns false on dispatch' => [
                static fn (self $self) => $self->assertChainJob(expected: false),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     *
     * @dataProvider dataChainJob
     */
    public function testChainJob(Closure $assert): void
    {
        $assert($this);
    }

    public function assertChainJob(bool $expected): void
    {
        $job = new WithoutCommandJob(name: 'Hello');
        $job2 = new WithoutCommandJob(name: 'Hello2');

        $action = $this->makeAction(new DispatchJobActionContractExpectation(return: $expected, job: $job));

        Assert::assertEquals(expected: $expected, actual: $action->execute([$job, $job2]));

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
