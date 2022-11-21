<?php

declare(strict_types=1);

namespace LaraStrict\Testing;

use LogicException;

abstract class AbstractExpectationCallsMap
{
    /**
     * @var array<string, array<object>>
     */
    private array $_expectationMap = [];

    /**
     * @var array<string, int>
     */
    private array $_callStep = [];

    /**
     * Contains current call number.
     */
    private int $_currentDebugStep = 0;

    public function addExpectation(string $key, object $expectation): self
    {
        $this->_expectationMap[$key][] = $expectation;

        return $this;
    }

    /**
     * @param array<object>  $expectations
     */
    public function setExpectations(string $key, array $expectations): self
    {
        $this->_expectationMap[$key] = $expectations;

        return $this;
    }

    protected function getExpectation(string $key): object
    {
        $map = $this->_expectationMap[$key] ?? [];
        $callStep = $this->_callStep[$key] ?? 0;

        $this->_currentDebugStep = $callStep + 1;

        if (array_key_exists($callStep, $map) === false) {
            throw new LogicException($this->getDebugMessage($this->_currentDebugStep, 'not set', 2));
        }

        $expectation = $map[$callStep];
        $this->_callStep[$key] = $this->_currentDebugStep;

        return $expectation;
    }

    protected function getDebugMessage(int $callStep = null, string $reason = 'failed', int $debugLevel = 1): string
    {
        $caller = debug_backtrace()[$debugLevel];

        return sprintf(
            'Expectation for [%s@%s] %s for a n (%s) call',
            $caller['class'] ?? $this::class,
            $caller['function'],
            $reason,
            $callStep ?? $this->_currentDebugStep
        );
    }
}
