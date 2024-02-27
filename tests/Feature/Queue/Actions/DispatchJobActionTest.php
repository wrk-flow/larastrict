<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Queue\Actions;

use Illuminate\Support\Facades\Queue;
use LaraStrict\Queue\Actions\DispatchJobAction;
use Tests\LaraStrict\Feature\TestCase;

final class DispatchJobActionTest extends TestCase
{
    public function testExecute(): void
    {
        Queue::fake();

        // DO not use Bus dispatcher interface! Use global dispatch method instead.
        $action = new DispatchJobAction();
        $action->execute(new WithoutCommandJob('test'));

        Queue::assertPushed(WithoutCommandJob::class, static fn ($job) => $job->getName() === 'test');
    }
}
