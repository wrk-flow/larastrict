<?php

declare(strict_types=1);

namespace LaraStrict\Database\Actions;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class SafeUniqueSaveAction
{
    /**
     * @var int
     */
    protected const DUPLICATION_ERROR_CODE = 1062;

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
    public function execute(Model $model, Closure $setupClosure, int $maxTries = 20, int $tries = 1): mixed
    {
        // In some cases (like generating variable symbol) there can be situations when the generated value is used
        // before insert it the value - lets "reset" it and generate a new one
        try {
            $result = $setupClosure($model, $tries);

            $model->saveOrFail();

            return $result;
        } catch (QueryException $queryException) {
            if (is_array($queryException->errorInfo) && isset($queryException->errorInfo[1])
                && $queryException->errorInfo[1] !== self::DUPLICATION_ERROR_CODE) {
                throw $queryException;
            }

            if ($maxTries <= $tries) {
                throw $queryException;
            }

            return $this->execute($model, $setupClosure, $maxTries, $tries + 1);
        }
    }
}
