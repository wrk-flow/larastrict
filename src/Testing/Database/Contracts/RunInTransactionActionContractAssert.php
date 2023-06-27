<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Database\Contracts;

use Closure;
use LaraStrict\Database\Contracts\RunInTransactionActionContract;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class RunInTransactionActionContractAssert extends AbstractExpectationCallsMap implements RunInTransactionActionContract
{
    /**
     * @param array<RunInTransactionActionContractExpectation|null> $expectations
     */
    public function __construct(array $expectations = [new RunInTransactionActionContractExpectation(false)])
    {
        parent::__construct();

        $this->setExpectations(RunInTransactionActionContractExpectation::class, $expectations);
    }

    /**
     * @template T
     *
     * @param Closure():T $callback
     *
     * @return T
     */
    public function execute(Closure $callback, int $attempts = 1): mixed
    {
        $expectation = $this->getExpectation(RunInTransactionActionContractExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->attempts, $attempts, $message);

        $result = $callback();

        if ($expectation->fail) {
            return $this->execute($callback, $attempts + 1);
        }

        return $result;
    }
}
