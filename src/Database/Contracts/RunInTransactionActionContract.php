<?php

declare(strict_types=1);

namespace LaraStrict\Database\Contracts;

use Closure;

interface RunInTransactionActionContract
{
    /**
     * @template T
     *
     * @param Closure():T $callback
     *
     * @return T
     */
    public function execute(Closure $callback, int $attempts = 1): mixed;
}
