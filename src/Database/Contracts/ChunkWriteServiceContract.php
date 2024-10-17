<?php

declare(strict_types=1);

namespace LaraStrict\Database\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Database\Entities\ChunkWriteStateEntity;

/**
 * @phpstan-type TData iterable<int|string, Model>
 */
interface ChunkWriteServiceContract
{
    /**
     * @param Closure(): TData|TData $closure
     */
    public function write(Closure|iterable $closure): ChunkWriteStateEntity;
}
