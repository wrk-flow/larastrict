<?php

declare(strict_types=1);

namespace LaraStrict\Queue;

use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Queue\Actions\DispatchChainJobsAction;
use LaraStrict\Queue\Actions\DispatchJobAction;
use LaraStrict\Queue\Actions\RunJobAction;
use LaraStrict\Queue\Actions\RunOrQueueJobAction;
use LaraStrict\Queue\Contracts\DispatchChainJobsActionContract;
use LaraStrict\Queue\Contracts\DispatchJobActionContract;
use LaraStrict\Queue\Contracts\RunJobActionContract;
use LaraStrict\Queue\Contracts\RunOrQueueJobActionContract;

class QueueServiceProvider extends AbstractServiceProvider
{
    public array $singletons = [
        DispatchJobActionContract::class => DispatchJobAction::class,
        RunJobActionContract::class => RunJobAction::class,
        RunOrQueueJobActionContract::class => RunOrQueueJobAction::class,
        DispatchChainJobsActionContract::class => DispatchChainJobsAction::class,
    ];
}
