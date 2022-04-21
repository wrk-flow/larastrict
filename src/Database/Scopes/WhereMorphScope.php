<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WhereMorphScope extends AbstractScope
{
    /**
     * @param class-string<Model> $morphedTo
     * @param int|string          $morphId
     * @param string              $relationName
     */
    public function __construct(
        private readonly string $morphedTo,
        private readonly int|string $morphId,
        private readonly string $relationName,
        private readonly string $typeName = 'type',
        private readonly string $idName = 'id',
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        /** @var Model $morphModel */
        $morphModel = new $this->morphedTo();

        $builder
            ->where(sprintf('%s_%s', $this->relationName, $this->typeName), $morphModel->getMorphClass())
            ->where(sprintf('%s_%s', $this->relationName, $this->idName), $this->morphId);
    }
}
