<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Adds whereIn or where condition for given values.
 */
abstract class AbstractInScope implements Scope
{
    public const BOOLEAN_AND = 'and';
    public const BOOLEAN_OR = 'or';

    private array $values;
    private string $boolean = self::BOOLEAN_AND;
    private bool $not;
    private string $table;

    /**
     * @param string|bool|null $booleanOrTableOrNot Pass false to set $not argument, pass string to set table or 'and'
     *                                              'or' value
     */
    public function __construct(
        array $values,
        string|bool|null $booleanOrTableOrNot = null,
        string $table = '',
        bool $not = false
    ) {
        $this->values = $values;

        if (is_bool($booleanOrTableOrNot) === true) {
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
            $builder->where(
                $column,
                $this->not === true ? '<>' : '=',
                reset($this->values),
                $this->boolean
            );

            return;
        }

        $builder->whereIn($column, $this->values, $this->boolean, $this->not);
    }

    abstract protected function getColumn(Model $model): string;
}
