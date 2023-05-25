<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Console\Jobs;

use Closure;
use LaraStrict\Console\Jobs\AbstractUniqueJob;
use PHPUnit\Framework\TestCase;

class AbstractUniqueJobTest extends TestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataQueue(): array
    {
        return [
            [
                static fn (self $self) => $self->assertQueue(job: new NoQueueJob(), expectedQueue: 'default'),
            ],
            [
                static fn (self $self) => $self->assertQueue(job: new CustomQueueJob(), expectedQueue: 'custom'),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     * @dataProvider dataQueue
     */
    public function testQueue(Closure $assert): void
    {
        $assert($this);
    }

    public function assertQueue(AbstractUniqueJob $job, string $expectedQueue): void
    {
        $this->assertEquals(expected: $expectedQueue, actual: $job->queue);
    }
}
