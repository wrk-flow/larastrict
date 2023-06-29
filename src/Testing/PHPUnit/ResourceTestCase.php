<?php

declare(strict_types=1);

namespace LaraStrict\Testing\PHPUnit;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Http\Resources\JsonResource as LaraStrictJsonResource;
use LaraStrict\Http\Resources\JsonResourceCollection;
use LaraStrict\Testing\Assert\AssertExpectationTestCase;
use LaraStrict\Testing\Laravel\TestingContainer;
use LogicException;
use Throwable;

/**
 * @template TEntity
 */
abstract class ResourceTestCase extends AssertExpectationTestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    abstract public function data(): array;

    /**
     * @param TEntity|callable():TEntity         $object
     * @param array<string|int, mixed>|Exception $expected
     * @param TestingContainer|null              $container Set container to the resource.
     */
    protected function assert(mixed $object, array|Exception $expected, ?TestingContainer $container = null): void
    {
        // Support catching LogicException below in our test cases.
        if ($expected instanceof Throwable) {
            $this->expectExceptionObject($expected);
        }

        $request = new Request();

        $resource = $this->createResource(is_callable($object) ? $object() : $object);

        if ($container !== null) {
            if ($resource instanceof LaraStrictJsonResource === false
                && $resource instanceof JsonResourceCollection === false) {
                throw self::containerCannotBeSetException();
            }

            $resource->setContainer($container);
        }

        if ($expected instanceof Throwable) {
            $this->expectExceptionObject($expected);
        }

        $result = $resource->resolve($request);

        $this->assertEquals(expected: $expected, actual: $result);
    }

    /**
     * @param TEntity $object
     */
    abstract protected function createResource(mixed $object): JsonResource;

    protected static function containerCannotBeSetException(): LogicException
    {
        return new LogicException(sprintf(
            'Container can only be set on %s or %s.',
            LaraStrictJsonResource::class,
            JsonResourceCollection::class
        ));
    }
}
