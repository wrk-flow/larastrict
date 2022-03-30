<?php

declare(strict_types=1);

namespace Larastrict\Database\Migrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

abstract class AbstractCreateMigration extends AbstractMigration
{
    public function up(): void
    {
        $this->create(
            $this->getModelClass(),
            function (Blueprint $table): void {
                $this->schema($table);
            }
        );
    }

    public function down(): void
    {
        $this->drop($this->getModelClass());
    }

    /**
     * @return class-string<Model>
     */
    abstract public function getModelClass(): string;

    abstract public function schema(Blueprint $table): void;
}
