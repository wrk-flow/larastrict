<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Tests\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LaraStrict\Tests\Traits\SqlTestEnable;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class SqlTestEnableTest extends TestCase
{
    use SqlTestEnable;

    public function testDatabaseFacadeUsesModelConnectionResolver(): void
    {
        Assert::assertSame(Model::getConnectionResolver(), DB::getFacadeRoot());
    }
}
