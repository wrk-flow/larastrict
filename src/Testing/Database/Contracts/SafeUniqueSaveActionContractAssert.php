<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Database\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Database\Contracts\SafeUniqueSaveActionContract;
use LaraStrict\Testing\AbstractExpectationCallMap;
use PHPUnit\Framework\Assert;

/**
 * @extends AbstractExpectationCallMap<SafeUniqueSaveActionContractExpectation>
 */
class SafeUniqueSaveActionContractAssert extends AbstractExpectationCallMap implements SafeUniqueSaveActionContract
{
    /**
     * Ensures that model will be reset if duplication error has occurred.
     *
     * @template T of Model
     * @template R
     *
     * @param T                  $model
     * @param Closure(T, int): R $setupClosure
     *
     * @return R Returns value from the closure (the latest value that was successfully stored)
     */
    public function execute(Model $model, Closure $setupClosure, int $maxTries = 20, int $tries = 1): mixed
    {
        $expectation = $this->getExpectation();
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->model, $model, $message);
        Assert::assertEquals($expectation->maxTries, $maxTries, $message);
        Assert::assertEquals($expectation->tries, $tries, $message);

        $result = $setupClosure($model, $tries);

        if ($expectation->fail) {
            return $this->execute($model, $setupClosure, $maxTries, $tries + 1);
        }

        $model->updateTimestamps();

        if ($expectation->setId !== null) {
            $model->setAttribute('id', $expectation->setId);
            $model->exists = true;
        }

        return $result;
    }
}
