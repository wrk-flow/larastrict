<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LogicException;

class WhereOnlySoftDeletedScope extends AbstractScope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (method_exists($model, 'getQualifiedDeletedAtColumn') === false) {
            throw new LogicException(
                'Unable to apply OnlySoftDeletedScope because ' . $model::class . ' model does not implement SoftDeletes trait',
            );
        }

        $builder->withoutGlobalScope(SoftDeletingScope::class)
            ->whereNotNull($model->getQualifiedDeletedAtColumn());
    }
}
