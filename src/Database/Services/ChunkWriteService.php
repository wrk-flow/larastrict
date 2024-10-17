<?php

declare(strict_types=1);

namespace LaraStrict\Database\Services;

use Closure;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Database\Contracts\ChunkWriteServiceContract;
use LaraStrict\Database\Entities\ChunkWriteStateEntity;
use LogicException;

final class ChunkWriteService implements ChunkWriteServiceContract
{
    public function write(Closure|iterable $closure, int $batchSize = 0): ChunkWriteStateEntity
    {
        $writeState = new ChunkWriteStateEntity(batchSize: $batchSize);

        $source = $closure instanceof Closure ? $closure() : $closure;
        foreach ($source as $model) {
            $this->add($model, $writeState);
        }

        $this->finish($writeState);

        return $writeState;
    }

    private function add(Model $model, ChunkWriteStateEntity $state): void
    {
        if ($model->usesTimestamps()) {
            $model->updateTimestamps();
        }

        /** @var array<string, string|int|bool|float> $attributes */
        $attributes = $model->getAttributes();
        $attributesCount = count($attributes);

        $modelClass = $model::class;

        if ($state->modelClass === null) {
            $state->modelClass = $modelClass;
        } elseif ($state->modelClass !== $modelClass) {
            throw new LogicException(sprintf(
                'Batch insert must contain items with same class <%s> got <%s>',
                $state->modelClass,
                $modelClass
            ));
        }

        // We need to prevent insert max statements by limiting number of insert
        if ($state->batchSize === 0) {
            $state->batchSize = (int) (65536 / $attributesCount);
        }

        if ($state->attributesCount !== 0 && $state->attributesCount !== $attributesCount) {
            throw new LogicException('Batch insert must contain items with same attributes count' . print_r(
                $attributes,
                true
            ));
        }

        $state->toWrite[] = $attributes;
        $state->attributesCount = $attributesCount;

        if ($state->batchSize === count($state->toWrite)) {
            $this->finish($state);
        }
    }

    private function finish(ChunkWriteStateEntity $state): void
    {
        if ($state->toWrite === [] || $state->modelClass === null) {
            return;
        }

        // Do not fail on duplicated entries.
        $count = $state->modelClass::insertOrIgnore($state->toWrite);

        $state->insertedCount += $count;
        $state->toWrite = [];
    }
}
