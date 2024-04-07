<?php

declare(strict_types=1);

namespace LaraStrict\Testing\PHPUnit;

use Closure;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;
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
    private ?Request $request = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = null;
    }

    public function getRequest(): Request
    {
        if (! $this->request instanceof Request) {
            $this->request = $this->createRequest();
        }

        return $this->request;
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    abstract static public function data(): array;

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

        $resource = $this->createResource(is_callable($object) ? $object() : $object);

        $this->tryToSetContainer(container: $container, resource: $resource);

        if ($expected instanceof Throwable) {
            $this->expectExceptionObject($expected);
        }

        $result = $resource->resolve($this->getRequest());

        $this->assertEquals(expected: $expected, actual: $result);
    }

    /**
     * @param TEntity $object
     */
    abstract protected function createResource(mixed $object): BaseJsonResource;

    /**
     * Calls toArray on the resource. If the resource is a LaraStrictJsonResource or JsonResourceCollection, the
     * container will be set on the resource (if provided).
     *
     * By default, the request is set from $this->getRequest() method.
     *
     * @return array<int|string, mixed>|null
     */
    protected function resourceArray(
        ?BaseJsonResource $resource,
        ?TestingContainer $container = null,
        Request $request = null
    ): ?array {
        if (! $resource instanceof BaseJsonResource) {
            return null;
        }

        $this->tryToSetContainer(container: $container, resource: $resource);

        return (array) $resource->toArray($request ?? $this->getRequest());
    }

    protected static function containerCannotBeSetException(): LogicException
    {
        return new LogicException(sprintf(
            'Container can only be set on %s or %s.',
            LaraStrictJsonResource::class,
            JsonResourceCollection::class
        ));
    }

    protected function createRequest(): Request
    {
        return new Request();
    }

    protected function tryToSetContainer(?TestingContainer $container, BaseJsonResource $resource): void
    {
        if (! $container instanceof TestingContainer) {
            return;
        }

        if ($resource instanceof LaraStrictJsonResource === false
            && $resource instanceof JsonResourceCollection === false) {
            throw self::containerCannotBeSetException();
        }

        $resource->setContainer($container);
    }
}
