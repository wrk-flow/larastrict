<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WhereWithSoftDeletedScope extends AbstractScope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->withoutGlobalScope(SoftDeletingScope::class);
    }
}
