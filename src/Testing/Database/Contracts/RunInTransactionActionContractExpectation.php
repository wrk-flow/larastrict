<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Database\Contracts;

final class RunInTransactionActionContractExpectation
{
    public function __construct(
        public readonly bool $fail,
        public readonly int $attempts = 1,
    ) {
    }
}
