<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Actions;

use LaraStrict\Queue\Contracts\DispatchJobActionContract;
use LaraStrict\Queue\Jobs\Job;

final class DispatchJobAction implements DispatchJobActionContract
{
    public function execute(Job $job): bool
    {
        // Laravel requires PendingDispatch instance to be used for dispatching jobs with ShouldBeUnique :(
        dispatch($job);

        return true;
    }
}
