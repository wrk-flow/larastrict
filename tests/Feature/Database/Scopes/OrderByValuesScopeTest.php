<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Scopes;

use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraStrict\Database\Scopes\OrderByValuesScope;
use Tests\LaraStrict\Feature\Database\Models\Test;
use Tests\LaraStrict\Feature\TestCase;

class OrderByValuesScopeTest extends TestCase
{
    public function testApply(): void
    {
        $query = Test::query()
            ->withoutGlobalScope(new SoftDeletingScope())
            ->withGlobalScope('test', new OrderByValuesScope(['1', 2, 's33'], Test::AttributeTest));

        $this->assertEquals(
            expected: 'select * from "tests" order by FIELD(`test`, ?, ?, ?) DESC',
            actual: $query->toSql()
        );

        $this->assertEquals(expected: ['1', 2, 's33'], actual: $query->getBindings());
    }
}
