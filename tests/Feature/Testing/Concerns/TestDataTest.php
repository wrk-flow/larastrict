<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use LaraStrict\Testing\Concerns\TestData;
use Tests\LaraStrict\Feature\TestCase;

class TestDataTest extends TestCase
{
    use TestData;

    public function data(): array
    {
        return [
            'can use $app when using $testCase parameter' => [
                static fn (self $testCase) => $testCase->assert(expectAppNull: false),
            ],
            '$app is null when using $this' => [
                fn () => $this->assert(expectAppNull: true),
            ],
            [
                fn () => $this->assert(expectAppNull: true),
            ],
        ];
    }

    private function assert(bool $expectAppNull): void
    {
        $this->assertEquals(
            $expectAppNull,
            null === $this->app,
            'Using $this in closure references test case without app initialized.'
        );
    }
}
