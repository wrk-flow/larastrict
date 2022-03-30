<?php

declare(strict_types=1);

namespace Larastrict\Database\Migrations;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use Larastrict\Database\Actions\RunInTransactionAction;

abstract class AbstractMigration extends Migration
{
    protected Builder $schema;
    protected RunInTransactionAction $runInTransaction;

    public function __construct()
    {
        $this->schema = app(Builder::class);
        $this->runInTransaction = app(RunInTransactionAction::class);
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
    protected function getTableName(string $modelClass): mixed
    {
        return (new $modelClass())->getTable();
    }
}
