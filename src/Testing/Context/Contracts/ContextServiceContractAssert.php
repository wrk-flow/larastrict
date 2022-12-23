<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contexts\AbstractIsContext;
use LaraStrict\Context\Contracts\ContextServiceContract;
use LaraStrict\Context\Contracts\ContextValueContract;
use LaraStrict\Context\Values\BoolContextValue;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class ContextServiceContractAssert extends AbstractExpectationCallsMap implements ContextServiceContract
{
    /**
     * @param array<ContextServiceContractDeleteExpectation> $delete
     * @param array<ContextServiceContractSetExpectation> $set
     * @param array<ContextServiceContractSetWithoutCacheExpectation> $setWithoutCache
     * @param array<ContextServiceContractGetExpectation> $get
     * @param array<ContextServiceContractIsExpectation> $is
     * @param array<ContextServiceContractGetCacheKeyExpectation> $getCacheKey
     */
    public function __construct(
        array $delete = [],
        array $set = [],
        array $setWithoutCache = [],
        array $get = [],
        array $is = [],
        array $getCacheKey = [],
    ) {
        $this->setExpectations(ContextServiceContractDeleteExpectation::class, array_values(array_filter($delete)));
        $this->setExpectations(ContextServiceContractSetExpectation::class, array_values(array_filter($set)));
        $this->setExpectations(
            ContextServiceContractSetWithoutCacheExpectation::class,
            array_values(array_filter($setWithoutCache))
        );
        $this->setExpectations(ContextServiceContractGetExpectation::class, array_values(array_filter($get)));
        $this->setExpectations(ContextServiceContractIsExpectation::class, array_values(array_filter($is)));
        $this->setExpectations(
            ContextServiceContractGetCacheKeyExpectation::class,
            array_values(array_filter($getCacheKey))
        );
    }

    public function delete(AbstractContext $context): void
    {
        $expectation = $this->getExpectation(ContextServiceContractDeleteExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->context, $context, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $context, $expectation);
        }
    }

    public function set(AbstractContext $context, ContextValueContract $value): void
    {
        $expectation = $this->getExpectation(ContextServiceContractSetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->context, $context, $message);
        Assert::assertEquals($expectation->value, $value, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $context, $value, $expectation);
        }
    }

    public function setWithoutCache(AbstractContext $context, ContextValueContract $value): void
    {
        $expectation = $this->getExpectation(ContextServiceContractSetWithoutCacheExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->context, $context, $message);
        Assert::assertEquals($expectation->value, $value, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $context, $value, $expectation);
        }
    }

    public function get(AbstractContext $context, Closure $createState): ContextValueContract
    {
        $expectation = $this->getExpectation(ContextServiceContractGetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->context, $context, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $context, $createState, $expectation);
        }

        if (is_callable($expectation->runCreateState)) {
            $result = call_user_func($expectation->runCreateState, $createState);

            Assert::assertEquals($result, $expectation->return);
        }

        /** @phpstan-ignore-next-line */
        return $expectation->return;
    }

    public function is(AbstractIsContext $context, Closure $is): BoolContextValue
    {
        $expectation = $this->getExpectation(ContextServiceContractIsExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->context, $context, $message);
        Assert::assertEquals($expectation->is, $is, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $context, $is, $expectation);
        }

        return $expectation->return;
    }

    public function getCacheKey(AbstractContext $context): string
    {
        $expectation = $this->getExpectation(ContextServiceContractGetCacheKeyExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->context, $context, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $context, $expectation);
        }

        return $expectation->return;
    }
}
