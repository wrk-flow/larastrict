<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Database\Contracts;

use Closure;
use LaraStrict\Database\Contracts\RunInTransactionActionContract;
use LaraStrict\Testing\AbstractExpectationCallMap;
use PHPUnit\Framework\Assert;

/**
 * @extends AbstractExpectationCallMap<RunInTransactionActionContractExpectation>
 */
class RunInTransactionActionContractAssert extends AbstractExpectationCallMap implements RunInTransactionActionContract
{
    public function __construct(array $expectationMap = [
        new RunInTransactionActionContractExpectation(false),
    ], int $callStep = 0)
    {
        parent::__construct($expectationMap, $callStep);
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
        $expectation = $this->getExpectation();
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->attempts, $attempts, $message);

        $result = $callback();

        if ($expectation->fail) {
            return $this->execute($callback, $attempts + 1);
        }

        return $result;
    }
}
