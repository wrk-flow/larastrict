<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Entities;

use LaraStrict\Testing\Enums\PhpType;

class PhpDocEntity
{
    public function __construct(
        public readonly PhpType $returnType = PhpType::Unknown,
    ) {
    }
}
