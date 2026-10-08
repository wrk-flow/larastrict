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
                    MessageJsonResource::collection($input),
                    MessageResource::collection($input),
                    false,
                    $output,
                ),
            ],
            'preserve keys true' => [
                static fn (self $self) => $self->assert(
                    PreserveKeysJsonResource::collection($input),
                    PreserveKeysLaraStrictResource::collection($input),
                    true,
                    $output,
                ),
            ],
            'preserve keys false by default - no container' => [
                static fn (self $self) => $self->assert(
                    MessageJsonResource::collection($input),
                    MessageResource::collection($input),
                    false,
                    $output,
                    false,
                ),
            ],
            'preserve keys true - no container' => [
                static fn (self $self) => $self->assert(
                    PreserveKeysJsonResource::collection($input),
                    PreserveKeysLaraStrictResource::collection($input),
                    true,
                    $output,
                    false,
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

    /**
     * @param array<array-key, mixed> $expectedOutput
     */
    public function assert(
        AnonymousResourceCollection $laravelCollection,
        JsonResourceCollection $laraStrictCollection,
        bool $expectedPreserveKeys,
        array $expectedOutput,
        bool $setContainer = true,
    ): void {
        $this->assertEquals($expectedPreserveKeys, $laravelCollection->preserveKeys, 'Laravel preserve keys');
        $this->assertEquals($expectedPreserveKeys, $laraStrictCollection->preserveKeys, 'LaraStrict preserve keys');

        $this->assertEquals(
            $expectedOutput,
            $laravelCollection->toArray($this->request),
            'Laravel toArray',
        );

        $this->assertEquals(
            $expectedOutput,
            $laraStrictCollection
                ->setContainer($setContainer ? new TestingContainer() : null)
                ->toArray($this->request),
            'LaraStrict toArray',
        );
    }
}
