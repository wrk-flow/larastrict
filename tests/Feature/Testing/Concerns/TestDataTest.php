<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use LaraStrict\Testing\Concerns\TestData;
use Tests\LaraStrict\Feature\TestCase;

class TestDataTest extends TestCase
{
    use TestData;

    public static function data(): array
    {
        return [
            'can use $app when using $self parameter' => [
                static fn (self $self) => $self->assert(expectAppNull: false),
            ],
        ];
    }

    private function assert(bool $expectAppNull): void
    {
        $this->assertEquals(
            expected: $expectAppNull,
            actual: null === $this->app,
            message: 'Using $this in closure references test case without app initialized.'
        );
    }
}
