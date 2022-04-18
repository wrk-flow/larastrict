<?php

declare(strict_types=1);

namespace LaraStrict\Database\Actions;

use Closure;
use Illuminate\Database\Connection;

class RunInTransactionAction
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function execute(Closure $callback, int $attempts = 1): mixed
    {
        return $this->connection->transaction($callback, $attempts);
    }
}
