<?php

declare(strict_types=1);

namespace Larastrict\Database\Actions;

use Closure;
use Illuminate\Database\Connection;
use Throwable;

class RunInTransactionAction
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Throwable
     */
    public function execute(Closure $callback, int $attempts = 1): mixed
    {
        return $this->connection->transaction($callback, $attempts);
    }
}
