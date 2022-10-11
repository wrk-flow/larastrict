<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use PHPUnit\Framework\TestCase;

abstract class AbstractRuleTest extends TestCase
{
    /**
     * @dataProvider testPassesData
     */
    public function testPasses(RuleExpectation $expectation): void
    {
        $rule = $this->createRule();

        $this->assertEquals($expectation->expectedIsValid, $rule->passes('test', $expectation->value));
    }

    public function testMessage(): void
    {
        $rule = $this->createRule();

        $this->assertEquals($this->getExpectedMessage(), str_replace(':attribute', 'test', $rule->message()));
    }

    abstract public function createRule(): Rule;

    /**
     * @return array<RuleExpectation>
     */
    abstract protected function testData(): array;

    abstract protected function getExpectedMessage(): string;

    protected function testPassesData(): array
    {
        $data = [];
        foreach ($this->testData() as $index => $entity) {
            $data[$index . ' with value: ' . $entity->value] = [$entity];
        }

        return $data;
    }
}
