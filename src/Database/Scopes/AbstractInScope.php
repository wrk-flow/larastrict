<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Adds whereIn or where condition for given values.
 */
abstract class AbstractInScope extends AbstractScope
{
    final public const BOOLEAN_AND = 'and';
    final public const BOOLEAN_OR = 'or';

    private string $boolean = self::BOOLEAN_AND;
    private readonly bool $not;
    private readonly string $table;

    /**
     * @param string|bool|null $booleanOrTableOrNot Pass false to set $not argument, pass string to set table or 'and'
     *                                              'or' value
     */
    public function __construct(
        private array $values,
        string|bool|null $booleanOrTableOrNot = null,
        string $table = '',
        bool $not = false,
    ) {
        if (is_bool($booleanOrTableOrNot)) {
            $not = $booleanOrTableOrNot;
            $booleanOrTableOrNot = null;
        }

        if (($booleanOrTableOrNot === self::BOOLEAN_AND || $booleanOrTableOrNot === self::BOOLEAN_OR)) {
            $this->boolean = $booleanOrTableOrNot;
        } elseif ($booleanOrTableOrNot !== null) {
            $table = $booleanOrTableOrNot;
        }

        $this->table = $table;
        $this->not = $not;
    }

    public function apply(Builder $builder, Model $model): void
    {
        $column = $this->table === '' ? $this->getColumn($model) : $this->table . '.' . $this->getColumn($model);
        if (count($this->values) === 1) {
            $builder->where($column, $this->not ? '<>' : '=', reset($this->values), $this->boolean);

            return;
        }

        $builder->whereIn($column, $this->values, $this->boolean, $this->not);
    }

    abstract protected function getColumn(Model $model): string;
}
