<?php

declare(strict_types=1);

namespace LaraStrict\Database\Migrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

abstract class AbstractAlterMigration extends AbstractMigration
{
    public function up(): void
    {
        $this->alter($this->getModelClass(), function (Blueprint $table): void {
            $this->changeSchema($table);
        });
    }

    public function down(): void
    {
        $this->alter($this->getModelClass(), function (Blueprint $table): void {
            $this->revertSchema($table);
        });
    }

    /**
     * @return class-string<Model>
     */
    abstract public function getModelClass(): string;

    abstract public function changeSchema(Blueprint $table): void;

    abstract public function revertSchema(Blueprint $table): void;
}
