<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Assert;

abstract class AbstractExpectationCallsMap
{
    /**
     * @var array<class-string<object>, array<object>>
     */
    private array $_expectationMap = [];

    /**
     * @var array<class-string<object>, int>
     */
    private array $_callStep = [];

    /**
     * Contains current call number.
     */
    private int $_currentDebugStep = 0;

    public function __construct()
    {
        AssertExpectationManager::getInstance()->register($this);
    }

    public function addExpectation(object $expectation): self
    {
        $this->_expectationMap[$expectation::class][] = $expectation;

        return $this;
    }

    /**
     * @template TExpectation
     *
     * @param class-string<TExpectation> $class
     * @param array<TExpectation|null>   $expectations
     */
    public function setExpectations(string $class, array $expectations): self
    {
        $this->_expectationMap[$class] = array_values(array_filter($expectations));
        $this->_callStep[$class] = 0;

        return $this;
    }

    public function assertCalled(): void
    {
        $errors = [];
        foreach ($this->_expectationMap as $class => $expectations) {
            $called = $this->_callStep[$class] ?? 0;
            $expected = count($expectations);
            if ($expected === $called) {
                continue;
            }

            $errors[] = sprintf('[%s] expected %d call/s but was called <%d> time/s', $class, $expected, $called);
        }

        if ($errors === []) {
            return;
        }

        throw new AssertException(implode(PHP_EOL, array_map(static fn(string $e) => $e, $errors)));
    }

    /**
     * @template TExpectation of object
     *
     * @param class-string<TExpectation> $class
     *
     * @return TExpectation
     */
    protected function getExpectation(string $class): object
    {
        $map = $this->_expectationMap[$class] ?? [];
        $callStep = $this->_callStep[$class] ?? 0;

        $this->_currentDebugStep = $callStep + 1;

        if (array_key_exists($callStep, $map) === false) {
            throw new AssertException($this->getDebugMessage($this->_currentDebugStep, 'not set', 2, true));
        }

        /** @var TExpectation $expectation */
        $expectation = $map[$callStep];
        $this->_callStep[$class] = $this->_currentDebugStep;

        return $expectation;
    }

    protected function getDebugMessage(
        int $callStep = null,
        string $reason = 'failed',
        int $debugLevel = 1,
        bool $addArguments = false
    ): string {
        $caller = debug_backtrace()[$debugLevel];

        // print_r / var_dump can cause high memory usage.
        $printableArguments = [];
        foreach ($caller['args'] as $arg) {
            if (is_object($arg)) {
                $printableArguments[] = $arg::class;
            } elseif (is_array($arg)) {
                $printableArguments[] = 'array with ' . count($arg) . ' element/s';
            } else {
                $printableArguments[] = (string)$arg;
            }
        }

        return sprintf(
            'Expectation for [%s@%s] %s for a n (%s) call%s',
            $caller['class'] ?? static::class,
            $caller['function'],
            $reason,
            $callStep ?? $this->_currentDebugStep,
            $addArguments === false ? '.' : (' with arguments: (' . implode(', ', $printableArguments) . ')')
        );
    }
}
