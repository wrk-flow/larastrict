<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use LaraStrict\Validation\Rules\NumberRule;

class NumberRuleTest extends AbstractRuleTest
{
    public function createRule(): Rule
    {
        return new NumberRule();
    }

    protected function testData(): array
    {
        return [
            new RuleExpectation('test', false),
            new RuleExpectation('234', true),
            new RuleExpectation(" -  1\t234. 065 ", true),
            new RuleExpectation('  1 234. 065 ', true),
            new RuleExpectation('-234', true),
            new RuleExpectation(234, true),
            new RuleExpectation(-234, true),
            new RuleExpectation(.0, true),
            new RuleExpectation(-.0, true),
            new RuleExpectation(0., true),
            new RuleExpectation(-0., true),
            new RuleExpectation('245.5', true),
            new RuleExpectation('-245.5', true),
            new RuleExpectation(245.50, true),
            new RuleExpectation(-245.50, true),
            new RuleExpectation('-01.50', true),
            new RuleExpectation('01.50', true),
            new RuleExpectation('01', true),
            new RuleExpectation('-01', true),
            new RuleExpectation('.50', true),
            new RuleExpectation('+.50', true),
            new RuleExpectation('-.50', true),
            new RuleExpectation('0', true),
            new RuleExpectation('.0', true),
            new RuleExpectation('0.', true),
            new RuleExpectation('0.0', true),
            new RuleExpectation('0,0', true),
            new RuleExpectation('0,50', true),
            new RuleExpectation(',', false),
            new RuleExpectation('-,', false),
            new RuleExpectation('.', false),
            new RuleExpectation('', false),
            new RuleExpectation(null, false),
            new RuleExpectation([], false),
            new RuleExpectation('9223372036854775807', false),
            new RuleExpectation('9223372036854775807.5', false),
            new RuleExpectation('922337203685477580703434355.5', false),
            new RuleExpectation('-922337203685477580703434355.5', false),
            new RuleExpectation('9223372036854775807', false),
            new RuleExpectation('9223372036854775807.5', false),
            new RuleExpectation('9223372036854775.5', false),
            new RuleExpectation('-922337203685477.5', false),
        ];
    }

    protected function getExpectedMessage(): string
    {
        return 'Given test is not a valid number or it exceeds int/float limits.';
    }
}
