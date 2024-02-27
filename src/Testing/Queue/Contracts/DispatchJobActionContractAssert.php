<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Queue\Contracts;

use LaraStrict\Queue\Contracts\DispatchJobActionContract;
use LaraStrict\Queue\Jobs\Job;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class DispatchJobActionContractAssert extends AbstractExpectationCallsMap implements DispatchJobActionContract
{
    /**
     * @param array<DispatchJobActionContractExpectation|null> $execute
     */
    public function __construct(array $execute = [])
    {
        parent::__construct();
        $this->setExpectations(DispatchJobActionContractExpectation::class, $execute);
    }

    public function execute(Job $job): bool
    {
        $_expectation = $this->getExpectation(DispatchJobActionContractExpectation::class);
        $_message = $this->getDebugMessage();

        Assert::assertEquals($_expectation->job, $job, $_message);

        if (is_callable($_expectation->_hook)) {
            call_user_func($_expectation->_hook, $job, $_expectation);
        }

        return $_expectation->return;
    }
}
