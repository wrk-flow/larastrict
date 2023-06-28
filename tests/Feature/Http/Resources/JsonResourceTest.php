<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

use LaraStrict\Testing\Laravel\TestingContainer;
use Tests\LaraStrict\Feature\TestCase;

class JsonResourceTest extends TestCase
{
    public function testByDefaultUsesLaravelContainer(): void
    {
        $resource = new LaraStrictResource(new TestEntity('test'));
        $this->assertEquals([
            'test' => 'test',
            'instance' => 'injected',
        ], $resource->resolve());
    }

    public function testCanUseCustomContainer(): void
    {
        $resource = new LaraStrictResource(new TestEntity('test'));
        $resource->setContainer(new TestingContainer(makeAlwaysBinding: static fn () => new TestAction('rock')));
        $this->assertEquals([
            'test' => 'test',
            'instance' => 'rock',
        ], $resource->resolve());
    }
}
