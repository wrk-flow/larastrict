<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Database\Contracts;

final readonly class RunInTransactionActionContractExpectation
{
    public function __construct(
        public bool $fail,
        public int $attempts = 1,
    ) {
    }
}
