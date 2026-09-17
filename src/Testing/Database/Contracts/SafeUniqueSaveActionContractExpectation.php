<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Database\Contracts;

use Illuminate\Database\Eloquent\Model;

final readonly class SafeUniqueSaveActionContractExpectation
{
    public function __construct(
        public Model $model,
        public bool $fail = false,
        public int $maxTries = 20,
        public int $tries = 1,
        public string|int|null $setId = null,
    ) {
    }
}
