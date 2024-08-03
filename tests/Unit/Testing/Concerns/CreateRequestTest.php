<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Concerns;

use LaraStrict\Testing\Concerns\CreateRequest;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Testing\Concerns\TestRequest;

class CreateRequestTest extends TestCase
{
    use CreateRequest;

    public function testNoContainerUsage(): void
    {
        $data = [
            TestRequest::KeyTest => 'value',
        ];
        $request = $this->createFormRequest(requestClass: TestRequest::class, data: $data);
        $this->assertEquals($data, $request->validated());
        $this->assertTrue($request->acceptsJson());
        $this->assertEquals('https://testing', $request->url());
    }

    public function testContainerUsage(): void
    {
        $data = [
            TestRequest::KeyTest => 'value',
        ];
        $customAction = new CustomAction();
        $request = $this->createFormRequest(
            requestClass: TestContainerRequest::class,
            data: $data,
            makeBindings: [
                CustomAction::class => $customAction,
            ],
        );
        $this->assertEquals($data, $request->validated());
        $this->assertTrue($request->acceptsJson());
        $this->assertEquals('https://testing', $request->url());
        $this->assertNotNull($customAction->autoAction);
        $this->assertEquals('test', $customAction->autoAction->test);
    }
}
