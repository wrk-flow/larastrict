<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use LaraStrict\Testing\Concerns\TestData;
use PHPUnit\Framework\TestCase;

class TestDataTest extends TestCase
{
    use TestData;

    public function data(): array
    {
        return [
            'test with key' => [
                fn () => $this->assert(value: true),
            ],
            [
                fn () => $this->assert(value: true),
            ],
        ];
    }

    private function assert(bool $value): void
    {
        $this->assertTrue($value);
    }
}
