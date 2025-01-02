<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Deprecated;

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
        private array|int|float|string|bool|null $values,
        #[Deprecated(reason: 'Use right parameter instead of this magic.')]
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
        $table = $this->table === '' ? $model->getTable() : $this->table;
        $column = sprintf('%s.', $table) . $this->getColumn($model);

        if (is_array($this->values) && count($this->values) === 1) {
            $this->values = reset($this->values);
        }

        if (is_array($this->values) === false) {
            $builder->where($column, $this->not ? '!=' : '=', $this->values, $this->boolean);

            return;
        }

        $builder->whereIn($column, $this->values, $this->boolean, $this->not);
    }

    abstract protected function getColumn(Model $model): string;
}
