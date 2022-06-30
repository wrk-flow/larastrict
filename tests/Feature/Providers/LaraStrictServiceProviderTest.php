<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers;

use Tests\LaraStrict\Feature\Database\Models\Test;
use Tests\LaraStrict\Feature\TestCase;

class LaraStrictServiceProviderTest extends TestCase
{
    public function testBootResolveFactory(): void
    {
        $result = Test::factory(1)->make()->first();

        $this->assertNotNull($result);
        $this->assertEquals($result->test, 1);
    }
}
