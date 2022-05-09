<?php

declare(strict_types=1);

namespace LaraStrict\Database\Migrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

/**
 * Applies same changeSchema / revertSchema on multiple models.
 */
abstract class AbstractAlterMultiMigration extends AbstractMigration
{
    public function up(): void
    {
        foreach ($this->getModelClasses() as $class) {
            $this->alter($class, function (Blueprint $table) use ($class): void {
                $this->changeSchema($table, $class);
            });
        }
    }

    public function down(): void
    {
        foreach ($this->getModelClasses() as $class) {
            $this->alter($class, function (Blueprint $table) use ($class): void {
                $this->revertSchema($table, $class);
            });
        }
    }

    /**
     * @return array<class-string<Model>>
     */
    abstract public function getModelClasses(): array;

    abstract public function changeSchema(Blueprint $table, string $class): void;

    abstract public function revertSchema(Blueprint $table, string $class): void;
}
