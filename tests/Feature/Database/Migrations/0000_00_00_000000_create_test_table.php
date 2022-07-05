<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Migrations;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Schema\Blueprint;
use LaraStrict\Database\Migrations\AbstractCreateMigration;
use Tests\LaraStrict\Feature\Database\Models\Test;

return new class() extends AbstractCreateMigration {
    public function getModelClass(): string
    {
        return Test::class;
    }

    public function schema(Blueprint $table): void
    {
        $table->integer(Test::AttributeTest);
        $table->softDeletes();
        $table->timestamps();
    }

    public function up(): void
    {
        parent::up();

        Test::factory(10)
            ->state(new Sequence([
                Test::AttributeDeletedAt => null,
            ], [
                Test::AttributeDeletedAt => now(),
            ],))
            ->create();
    }
};
