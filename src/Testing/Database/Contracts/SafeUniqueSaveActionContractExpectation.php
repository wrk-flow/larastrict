<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Database\Contracts;

use Illuminate\Database\Eloquent\Model;

final class SafeUniqueSaveActionContractExpectation
{
    public function __construct(
        public readonly Model $model,
        public readonly bool $fail = false,
        public readonly int $maxTries = 20,
        public readonly int $tries = 1,
    ) {
    }
}
