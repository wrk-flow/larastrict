<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TestModel>
 */
class TestModelFactory extends Factory
{
    public function definition()
    {
        return [
            TestModel::AttributeTest => 1,
            TestModel::AttributeDeletedAt => null,
        ];
    }
}
