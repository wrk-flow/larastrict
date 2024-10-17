<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Database\Services;

use Closure;
use LaraStrict\Database\Contracts\ChunkWriteServiceContract;
use LaraStrict\Database\Entities\ChunkWriteStateEntity;
use LaraStrict\Database\Services\ChunkWriteService;
use LaraStrict\Tests\Traits\SqlTestEnable;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @phpstan-import-type TData from ChunkWriteServiceContract
 */
final class ChunkWriteServiceTest extends TestCase
{
    use SqlTestEnable;

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function data(): array
    {
        return [
            [
                'empty' => static function (self $self) {
                    $self->assert(new ChunkWriteStateEntity(), static function () {
                        yield from [];
                    },);
                },
            ],
            [
                static function (self $self) {
                    $self->assert(
                        new ChunkWriteStateEntity(32768, TestModel::class, 3, 2),
                        static function () {
                            yield from [new TestModel(), new TestModel(), new TestModel()];
                        },
                    );
                },
            ],
            [
                static function (self $self) {
                    $self->assert(
                        new ChunkWriteStateEntity(32768, TestModel::class, 3, 2),
                        [new TestModel(), new TestModel(), new TestModel()],
                    );
                },
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     * @dataProvider data
     */
    public function test(Closure $assert): void
    {
        $assert($this);
    }

    /**
     * @param Closure(): TData|TData $data
     */
    public function assert(ChunkWriteStateEntity $expected, Closure|iterable $data): void
    {
        $state = (new ChunkWriteService())->write($data);
        Assert::assertEquals($expected, $state);
    }
}
