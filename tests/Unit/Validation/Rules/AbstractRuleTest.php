<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Validation\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use LaraStrict\Testing\Laravel\Contracts\Translation\TranslatorAssert;
use PHPUnit\Framework\TestCase;

/**
 * @todo move to testing package
 */
abstract class AbstractRuleTest extends TestCase
{
    /**
     * @dataProvider passesData
     */
    public function testPasses(RuleExpectation $expectation): void
    {
        $rule = $this->createRule();

        $failed = false;
        $fail = function (string $message) use (&$failed): PotentiallyTranslatedString {
            $failed = true;
            $this->assertEquals($this->getExpectedMessage(), str_replace(':attribute', 'test', $message));
            return new PotentiallyTranslatedString($message, new TranslatorAssert());
        };

        $rule->validate('test', $expectation->value, $fail);

        $this->assertEquals($expectation->expectedIsValid, $failed === false);
    }

    abstract public function createRule(): ValidationRule;

    /**
     * @return array<RuleExpectation>
     */
    abstract protected function data(): array;

    abstract protected function getExpectedMessage(): string;

    protected function passesData(): array
    {
        $data = [];
        foreach ($this->data() as $index => $entity) {
            $data[$index . ' with value: ' . $entity->value] = [$entity];
        }

        return $data;
    }
}
