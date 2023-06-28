<?php

declare(strict_types=1);

namespace LaraStrict\Testing\PHPUnit;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Http\Resources\JsonResource as LaraStrictJsonResource;
use LaraStrict\Testing\Assert\AssertExpectationTestCase;
use LaraStrict\Testing\Laravel\TestingContainer;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\Adapter\Phpunit\MockeryTestCaseSetUp;

/**
 * @template TEntity of object
 */
abstract class ResourceTestCase extends AssertExpectationTestCase
{
    use MockeryPHPUnitIntegration;
    use MockeryTestCaseSetUp;

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    abstract public function data(): array;

    /**
     * @param Closure(static):void $assert
     * @dataProvider data
     */
    public function test(Closure $assert): void
    {
        $assert($this);
    }

    protected function mockeryTestSetUp(): void
    {
    }

    protected function mockeryTestTearDown(): void
    {
    }

    /**
     * @param TEntity $object
     * @param array<string|int, mixed>  $expected
     * @param TestingContainer|null $container Set container to the resource.
     */
    protected function assert(object $object, array $expected, ?TestingContainer $container = null): void
    {
        $request = new Request();

        $resource = $this->createResource($object);

        if ($resource instanceof LaraStrictJsonResource && $container !== null) {
            $resource->setContainer($container);
        }

        $this->assertEquals(expected: $expected, actual: $resource->resolve($request));
    }

    /**
     * @param TEntity $object
     */
    abstract protected function createResource(object $object): JsonResource;
}
