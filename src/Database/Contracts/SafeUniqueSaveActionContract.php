<?php

declare(strict_types=1);

namespace LaraStrict\Database\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Model;

interface SafeUniqueSaveActionContract
{
    /**
     * Ensures that model will be reset if duplication error has occurred.
     *
     * @template T of Model
     * @template R
     *
     * @param T                  $model
     * @param Closure(T, int): R $setupClosure
     *
     * @return R Returns value from the closure (the latest value that was successfully stored)
     */
    public function execute(Model $model, Closure $setupClosure, int $maxTries = 20, int $tries = 1): mixed;
}
