<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Actions;

use LaraStrict\Testing\Actions\GetBasePathForStubsAction;
use LaraStrict\Testing\Laravel\TestingApplication;
use PHPUnit\Framework\TestCase;

class GetBasePathForStubsActionTest extends TestCase
{
    public function testExecute(): void
    {
        $action = new GetBasePathForStubsAction(new TestingApplication());
        $this->assertEquals('base', $action->execute());
    }
}
