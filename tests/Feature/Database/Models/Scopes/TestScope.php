<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Database\Scopes\AbstractScope;
use Tests\LaraStrict\Feature\Database\Models\TestModel;

class TestScope extends AbstractScope
{
    public function __construct(
        private readonly string $value = '',
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(TestModel::AttributeTest, $this->value);
    }
}
