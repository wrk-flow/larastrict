<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Http\Resources;

use Illuminate\Http\Request;
use LaraStrict\Http\Resources\UpdatedResource;
use PHPUnit\Framework\TestCase;

class UpdatedResourceTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            expected: [
                'message' => 'updated',
            ],
            actual: (new UpdatedResource())->toArray(new Request()),
        );
    }
}
