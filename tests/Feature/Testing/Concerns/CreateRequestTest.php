<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use LaraStrict\Testing\Concerns\CreateRequest;
use Tests\LaraStrict\Feature\TestCase;

class CreateRequestTest extends TestCase
{
    use CreateRequest;

    public function testSuccess(): void
    {
        $data = [
            TestRequest::KeyTest => 'value',
        ];
        $request = $this->createAndValidateRequest($this->app(), requestClass: TestRequest::class, data: $data);
        $this->assertEquals($data, $request->validated());
        $this->assertTrue($request->acceptsJson());
        $this->assertEquals('https://testing', $request->url());
    }

    public function testFail(): void
    {
        $this->expectExceptionMessage('The test field is required.');
        $this->createAndValidateRequest($this->app(), TestRequest::class, []);
    }
}
