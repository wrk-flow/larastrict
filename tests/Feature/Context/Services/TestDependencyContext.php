<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Context\Services;

use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contracts\ContextServiceContract;
use PHPUnit\Framework\Assert;

class TestDependencyContext extends AbstractContext
{
    public function __construct(
        private readonly string $value,
    ) {
    }

    public function get(ContextServiceContract $contextService): TestValue
    {
        $value = $contextService->get(
            context: $this,
            createState: fn (string $dependency): TestValue => new TestValue($this->value),
        );

        Assert::assertEquals($this->value, $value->value);
        Assert::assertInstanceOf(TestValue::class, $value);

        return $value;
    }

    public function getCacheKey(): string
    {
        return $this->value;
    }
}
