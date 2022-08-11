<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Core\Actions;

use LaraStrict\Core\Actions\PipeAction;
use PHPUnit\Framework\TestCase;

class PipeActionTest extends TestCase
{
    private PipeAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new PipeAction();
    }

    public function testDefault(): void
    {
        $this->assertNull(
            $this->action->execute([
                fn () => null,
                fn () => null,
            ]),
            'Should receive null when default closure is not set'
        );

        $this->assertEquals(
            'test',
            $this->action->execute([
                fn () => null,
                fn () => null,
            ], fn () => 'test'),
            'Should receive test from default closure'
        );
    }

    public function testReturn(): void
    {
        $this->assertEquals(
            'marco',
            $this->action->execute([
                fn () => 'marco',
                fn () => null,
            ]),
            'Should receive null when default closure is not set'
        );

        $this->assertEquals(
            'polo',
            $this->action->execute([
                fn () => null,
                fn () => 'polo',
            ], fn () => 'test'),
            'Should receive test from default closure'
        );
    }
}
