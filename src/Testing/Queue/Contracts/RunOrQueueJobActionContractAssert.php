<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use Closure;
use Illuminate\Console\Command;
use LaraStrict\Queue\Contracts\RunOrQueueJobActionContract;
use LaraStrict\Queue\Jobs\Job;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class RunOrQueueJobActionContractAssert extends AbstractExpectationCallsMap implements RunOrQueueJobActionContract
{
    /**
     * @param array<RunOrQueueJobActionContractExpectation|null> $execute
     */
    public function __construct(array $execute = [])
    {
        parent::__construct();
        $this->setExpectations(RunOrQueueJobActionContractExpectation::class, $execute);
    }

    public function execute(
        Job $job,
        Command $command = null,
        ?Closure $setupBeforeRun = null,
        bool $shouldQueue = null,
    ): mixed {
        $_expectation = $this->getExpectation(RunOrQueueJobActionContractExpectation::class);
        $_message = $this->getDebugMessage();

        Assert::assertEquals($_expectation->job, $job, $_message);
        Assert::assertEquals($_expectation->command, $command, $_message);
        Assert::assertEquals($_expectation->setupBeforeRun, $setupBeforeRun, $_message);
        Assert::assertEquals($_expectation->shouldQueue, $shouldQueue, $_message);

        if (is_callable($_expectation->_hook)) {
            call_user_func($_expectation->_hook, $job, $command, $setupBeforeRun, $shouldQueue, $_expectation);
        }

        return $_expectation->return;
    }
}
