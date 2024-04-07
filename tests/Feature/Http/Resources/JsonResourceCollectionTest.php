<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use LaraStrict\Http\Resources\JsonResourceCollection;
use LaraStrict\Http\Resources\MessageResource;
use LaraStrict\Testing\Laravel\TestingContainer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class JsonResourceCollectionTest extends TestCase
{
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new Request();
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function data(): array
    {
        // Preserve keys changes keys using mergeData, not input/output array
        $input = [
            1 => '1',
            2 => '2',
        ];
        $output = [
            1 => [
                'message' => '1',
            ],
            2 => [
                'message' => '2',
            ],
        ];

        return [
            'preserve keys false by default' => [
                static fn (self $self) => $self->assert(
                    laravelCollection: MessageJsonResource::collection($input),
                    laraStrictCollection: MessageResource::collection($input),
                    expectedPreserveKeys: false,
                    expectedOutput: $output,
                ),
            ],
            'preserve keys true' => [
                static fn (self $self) => $self->assert(
                    laravelCollection: PreserveKeysJsonResource::collection($input),
                    laraStrictCollection: PreserveKeysLaraStrictResource::collection($input),
                    expectedPreserveKeys: true,
                    expectedOutput: $output,
                ),
            ],
            'preserve keys false by default - no container' => [
                static fn (self $self) => $self->assert(
                    laravelCollection: MessageJsonResource::collection($input),
                    laraStrictCollection: MessageResource::collection($input),
                    expectedPreserveKeys: false,
                    expectedOutput: $output,
                    setContainer: false,
                ),
            ],
            'preserve keys true - no container' => [
                static fn (self $self) => $self->assert(
                    laravelCollection: PreserveKeysJsonResource::collection($input),
                    laraStrictCollection: PreserveKeysLaraStrictResource::collection($input),
                    expectedPreserveKeys: true,
                    expectedOutput: $output,
                    setContainer: false,
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('data')]
    public function test(Closure $assert): void
    {
        $assert($this);
    }

    public function assert(
        AnonymousResourceCollection $laravelCollection,
        JsonResourceCollection $laraStrictCollection,
        bool $expectedPreserveKeys,
        array $expectedOutput,
        bool $setContainer = true,
    ): void {
        // preserveKeys was added Laravel v9.45.0
        if (property_exists($laravelCollection, 'preserveKeys')) {
            $this->assertEquals(
                expected: $expectedPreserveKeys,
                actual: $laravelCollection->preserveKeys,
                message: 'Laravel preserve keys',
            );
        }

        if (property_exists($laraStrictCollection, 'preserveKeys')) {
            $this->assertEquals(
                expected: $expectedPreserveKeys,
                actual: $laraStrictCollection->preserveKeys,
                message: 'LaraStrict preserve keys',
            );
        }

        $this->assertEquals(
            expected: $expectedOutput,
            actual: $laravelCollection->toArray($this->request),
            message: 'Laravel toArray',
        );

        $this->assertEquals(
            expected: $expectedOutput,
            actual: $laraStrictCollection
                ->setContainer($setContainer ? new TestingContainer() : null)
                ->toArray($this->request),
            message: 'LaraStrict toArray',
        );
    }
}
