<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Testing\Laravel\TestingContainer;
use LaraStrict\Testing\PHPUnit\ResourceTestCase;
use Tests\LaraStrict\Feature\Http\Resources\LaraStrictResource;
use Tests\LaraStrict\Feature\Http\Resources\TestAction;
use Tests\LaraStrict\Feature\Http\Resources\TestEntity;
use Tests\LaraStrict\Unit\Testing\PHPUnit\LaravelResource;

/**
 * @extends ResourceTestCase<JsonResource>
 */
class JsonResourceTest extends ResourceTestCase
{
    private const Value = 'val123';
    private const KeyRes = 'res';
    private const KeyInstance = 'instance';
    private const KeyTest = 'test';

    public function data(): array
    {
        $container = new TestingContainer(
            makeAlwaysBinding: static fn () => new TestAction(value: '1')
        );
        $entity = new TestEntity(value: self::Value);
        $laraStrictResource = new LaraStrictResource($entity);
        $laravelResource = new LaravelResource($entity);
        $laravelCollection = LaravelResource::collection([$entity]);
        $laraStrictCollection = LaraStrictResource::collection([$entity]);

        return [
            'sets container to larastrict resource' => [
                fn (self $self) => $this->assert(
                    object: $laraStrictResource,
                    expected: self::expected(instance: '1'),
                    container: $container
                ),
            ],
            'sets laravel container to larastrict resource if not provided' => [
                fn (self $self) => $this->assert(
                    object: $laraStrictResource,
                    expected: self::expected(instance: 'injected')
                ),
            ],
            'collection sets container to larastrict resource' => [
                fn (self $self) => $this->assert(
                    object: $laraStrictCollection,
                    expected: self::expectedCollection(instance: '1'),
                    container: $container
                ),
            ],
            'collection sets laravel container to larastrict resource if not provided' => [
                fn (self $self) => $this->assert(
                    object: $laraStrictCollection,
                    expected: self::expectedCollection(instance: 'injected')
                ),
            ],
            'does not container to normal resource if provided' => [
                fn (self $self) => $this->assert(
                    object: $laravelResource,
                    expected: self::expected(instance: null),
                    container: $container
                ),
            ],
            'does not container to normal resource if not provided' => [
                fn (self $self) => $this->assert(object: $laravelResource, expected: self::expected(instance: null)),
            ],
            'collection does not container to normal resource if provided' => [
                fn (self $self) => $this->assert(
                    object: $laravelResource,
                    expected: self::expected(instance: null),
                    container: $container
                ),
            ],
            'collection does not container to normal resource if not provided' => [
                fn (self $self) => $this->assert(
                    object: $laravelCollection,
                    expected: self::expectedCollection(instance: null)
                ),
            ],
        ];
    }

    /**
     * @param callable(self):void $assert
     *
     * @dataProvider data
     */
    public function test(callable $assert): void
    {
        $assert($this);
    }

    protected function createResource(mixed $object): JsonResource
    {
        return new ResourceArrayResource($object);
    }

    /**
     * @return array<string, array<string, string>>
     */
    private static function expected(?string $instance): array
    {
        return [
            self::KeyRes => array_filter([
                self::KeyTest => self::Value,
                self::KeyInstance => $instance,
            ]),
        ];
    }

    /**
     * @return array<string, array<array<string, string>>>
     */
    private static function expectedCollection(?string $instance): array
    {
        return [
            self::KeyRes => [
                array_filter([
                    self::KeyTest => self::Value,
                    self::KeyInstance => $instance,
                ]),
            ],
        ];
    }
}
