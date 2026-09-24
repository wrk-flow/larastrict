<?php

declare(strict_types=1);

namespace LaraStrict\Database\Actions;

use Closure;
use Illuminate\Database\Connection;
use LaraStrict\Database\Contracts\RunInTransactionActionContract;

class RunInTransactionAction implements RunInTransactionActionContract
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    /**
     * @template T
     * @param Closure():T $callback
     * @phpstan-param int<1, max> $attempts
     *
     * @return T
     */
    public function execute(Closure $callback, int $attempts = 1): mixed
    {
        return $this->connection->transaction($callback, $attempts);
    }
}
