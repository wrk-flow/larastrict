<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

class TestAction
{
    public function __construct(
        private readonly string $value = 'injected',
    ) {
    }

    public function execute(): string
    {
        return $this->value;
    }
}
