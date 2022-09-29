<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Actions;

use LaraStrict\Testing\Actions\GetDevBasePathForStubs;
use LaraStrict\Testing\Laravel\TestingApplication;
use PHPUnit\Framework\TestCase;

class GetDevBasePathForStubsTest extends TestCase
{
    public function testPathExists(): void
    {
        $action = new GetDevBasePathForStubs(new TestingApplication(basePath: __DIR__));
        $expectedPath = str_replace('/tests/Unit/Testing/Actions', '', __DIR__);
        $this->assertEquals($expectedPath, $action->execute());
    }

    public function testPathDoesNotExists(): void
    {
        $this->expectExceptionMessage('Failed to create dev base path');
        $action = new GetDevBasePathForStubs(new TestingApplication());
        $action->execute();
    }
}
