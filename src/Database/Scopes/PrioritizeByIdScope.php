<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PrioritizeByIdScope implements Scope
{
    /**
     * @var int[]
     */
    private array $ids;
    private string $idColumn;

    /**
     * @param int[] $ids
     */
    public function __construct(array $ids, string $idColumn)
    {
        $this->ids = $ids;
        $this->idColumn = $idColumn;
    }

    public function apply(Builder $builder, Model $model): void
    {
        $placeholders = array_map(function () {
            return '?';
        }, $this->ids);

        $builder->orderByRaw(
            'FIELD(' . $this->idColumn . ', ' . implode(', ', $placeholders) . ') DESC',
            $this->ids
        );
    }
}
