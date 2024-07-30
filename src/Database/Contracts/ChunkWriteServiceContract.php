<?php

declare(strict_types=1);

namespace LaraStrict\Database\Contracts;

use Closure;
use Generator;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Database\Entities\ChunkWriteStateEntity;

interface ChunkWriteServiceContract
{
    /**
     * @param Closure(): Generator<int, Model> $closure
     */
    public function write(Closure $closure): ChunkWriteStateEntity;
}
