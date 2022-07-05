<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Test>
 */
class TestFactory extends Factory
{
    public function definition()
    {
        return [
            Test::AttributeTest => 1,
            Test::AttributeDeletedAt => null,
        ];
    }
}
