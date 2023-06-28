<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

class TestEntity
{
    public function __construct(
        public readonly string $value
    ) {
    }
}
