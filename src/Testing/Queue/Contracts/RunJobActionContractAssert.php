<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use Illuminate\Console\Command;
use LaraStrict\Queue\Contracts\RunJobActionContract;
use LaraStrict\Queue\Jobs\Job;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class RunJobActionContractAssert extends AbstractExpectationCallsMap implements RunJobActionContract
{
    /**
     * @param array<RunJobActionContractExpectation|null> $execute
     */
    public function __construct(array $execute = [])
    {
        parent::__construct();
        $this->setExpectations(RunJobActionContractExpectation::class, $execute);
    }

    public function execute(Job $job, Command $command = null, string $method = null): mixed
    {
        $_expectation = $this->getExpectation(RunJobActionContractExpectation::class);
        $_message = $this->getDebugMessage();

        if (is_callable($_expectation->_preHook)) {
            call_user_func($_expectation->_preHook, $job, $command, $method, $_expectation);
        }

        Assert::assertEquals($_expectation->job, $job, $_message);
        Assert::assertEquals($_expectation->command, $command, $_message);
        Assert::assertEquals($_expectation->method, $method, $_message);

        if (is_callable($_expectation->_hook)) {
            call_user_func($_expectation->_hook, $job, $command, $method, $_expectation);
        }

        return $_expectation->return;
    }
}
