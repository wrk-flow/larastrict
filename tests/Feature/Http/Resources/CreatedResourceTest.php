<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Http\Resources;

use Illuminate\Http\Request;
use LaraStrict\Http\Resources\CreatedResource;
use Tests\LaraStrict\Feature\TestCase;

class CreatedResourceTest extends TestCase
{
    public function testSetsCode201(): void
    {
        $response = (new CreatedResource(id: 1))->toResponse($this->app()->make(Request::class));

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('{"message":"created","data":{"id":1}}', $response->getContent());
    }
}
