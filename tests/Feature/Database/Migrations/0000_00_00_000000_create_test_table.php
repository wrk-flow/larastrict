<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Migrations;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Schema\Blueprint;
use LaraStrict\Database\Migrations\AbstractCreateMigration;
use Tests\LaraStrict\Feature\Database\Models\TestModel;

return new class() extends AbstractCreateMigration {
    public function getModelClass(): string
    {
        return TestModel::class;
    }

    public function schema(Blueprint $table): void
    {
        $table->integer(TestModel::AttributeTest);
        $table->softDeletes();
        $table->timestamps();
    }

    public function up(): void
    {
        parent::up();

        /** @var Factory<TestModel> $factory */
        $factory = TestModel::factory(10);
        $factory->state(new Sequence([
            TestModel::AttributeDeletedAt => null,
        ], [
            TestModel::AttributeDeletedAt => now(),
        ], ))
            ->create();
    }
};
