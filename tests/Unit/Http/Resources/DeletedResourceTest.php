<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Http\Resources;

use Illuminate\Http\Request;
use LaraStrict\Http\Resources\DeletedResource;
use PHPUnit\Framework\TestCase;

class DeletedResourceTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            [
                'message' => 'deleted',
            ],
            (new DeletedResource())->toArray(new Request()),
        );
    }
}
