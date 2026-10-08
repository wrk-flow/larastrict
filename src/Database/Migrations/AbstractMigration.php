<?php

declare(strict_types=1);

namespace LaraStrict\Database\Migrations;

use BackedEnum;
use Closure;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use LaraStrict\Database\Actions\RunInTransactionAction;

abstract class AbstractMigration extends Migration
{
    protected Builder $schema;
    protected RunInTransactionAction $runInTransaction;
    protected DatabaseManager $databaseManager;

    public function __construct()
    {
        $this->schema = app(Builder::class);
        $this->runInTransaction = app(RunInTransactionAction::class);
        $this->databaseManager = app(DatabaseManager::class);
    }

    abstract public function up(): void;

    abstract public function down(): void;

    /**
     * @param class-string<Model> $modelClass
     */
    protected function create(string $modelClass, Closure $closure): void
    {
        $this->schema->create($this->getTableName($modelClass), $closure);
    }

    /**
     * @param class-string<Model> $modelClass
     */
    protected function alter(string $modelClass, Closure $closure): void
    {
        $this->schema->table($this->getTableName($modelClass), $closure);
    }

    /**
     * @param class-string<Model> $modelClass
     */
    protected function drop(string $modelClass): void
    {
        $this->schema->dropIfExists($this->getTableName($modelClass));
    }

    /**
     * @param class-string<Model> $modelClass
     */
    protected function getTableName(string $modelClass): string
    {
        return (new $modelClass())->getTable();
    }

    /**
     * @param class-string<Model> $modelClass
     */
    protected function getKeyName(string $modelClass): string
    {
        return (new $modelClass())->getKeyName();
    }

    /**
     * Most used definition of relation:
     *
     * - if nullable cascade set to null
     * - if not nullable cascade set to delete
     *
     * @param class-string<Model> $modelClass
     */
    protected function relation(
        Blueprint $table,
        string $modelClass,
        string $column,
        bool $nullable = false,
        ?string $after = null,
    ): void {
        $columnDefinition = $table
            ->foreignIdFor($modelClass, $column)
            ->nullable($nullable);

        if ($after !== null) {
            $columnDefinition->after($after);
        }

        $foreign = $table->foreign($column)
            ->on($this->getTableName($modelClass))
            ->references($this->getKeyName($modelClass));

        if ($nullable) {
            $foreign->nullOnDelete();
        } else {
            $foreign->cascadeOnDelete();
        }
    }

    protected function dropRelation(Blueprint $table, string $column): void
    {
        $table->dropForeign([$column]);
        $table->dropColumn([$column]);
    }

    /**
     * Creates the alter table of column.
     *
     * @param array<string> $values
     */
    protected function alterEnum(
        Blueprint $table,
        string $column,
        array $values,
        string|null $default = null,
        ?string $after = null,
        string $alterType = 'MODIFY COLUMN',
    ): void {
        // setup the default
        $defaultString = '';

        if (null === $default) {
            $defaultString .= ' NULL';
        } else {
            $defaultString .= "NOT NULL DEFAULT '" . $default . "'";
        }

        // create new columns
        $newValues = [];

        foreach ($values as $newValue) {
            $newValues[] = "'" . $newValue . "'";
        }

        // build the enum
        $enum = implode(', ', $newValues);

        if ($after !== null) {
            $defaultString .= sprintf(' AFTER `%s`', $after);
        }

        $this->databaseManager
            ->connection($this->getConnection())
            ->statement(
                sprintf(
                    'ALTER TABLE `%s` %s `%s` ENUM(%s) %s',
                    $table->getTable(),
                    $alterType,
                    $column,
                    $enum,
                    $defaultString,
                ),
            );
    }

    /**
     * @param array<BackedEnum> $cases
     *
     * @return array<string>
     */
    protected function enumValues(array $cases): array
    {
        return array_map(static fn (BackedEnum $enum): string => (string) $enum->value, $cases);
    }
}
