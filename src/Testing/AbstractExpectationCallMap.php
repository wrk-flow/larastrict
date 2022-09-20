<?php

declare(strict_types=1);

namespace LaraStrict\Testing;

use LogicException;

/**
 * @template T of object
 */
abstract class AbstractExpectationCallMap
{
    /**
     * @var array<T>
     */
    private readonly array $expectationMap;

    /**
     * @param array<T|null> $expectationMap
     */
    public function __construct(
        array $expectationMap,
        private int $callStep = 0
    ) {
        // Support passing "built" array of calls and ensure it is correctly key-ed
        $this->expectationMap = array_values(array_filter($expectationMap));
    }

    /**
     * @return T
     */
    protected function getExpectation(): object
    {
        if (array_key_exists($this->callStep, $this->expectationMap) === false) {
            throw new LogicException($this->getDebugMessage($this->callStep + 1, 'not set', 2));
        }

        $expectation = $this->expectationMap[$this->callStep];
        ++$this->callStep;

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
            $callStep ?? $this->callStep
        );
    }
}
