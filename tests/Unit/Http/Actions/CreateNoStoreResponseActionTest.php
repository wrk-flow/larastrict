<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Http\Actions;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use LaraStrict\Http\Actions\CreateNoStoreResponseAction;
use PHPUnit\Framework\TestCase;

class CreateNoStoreResponseActionTest extends TestCase
{
    public function testResourceResponseUsesInjectedRequestAndPreservesContent(): void
    {
        foreach ([JsonResource::class, ResourceCollection::class] as $resourceClass) {
            $request = new Request();
            $response = new JsonResponse([
                'data' => [
                    'value' => 'resource',
                ],
            ], 202);
            $resource = $this->createMock($resourceClass);
            $resource->expects($this->once())
                ->method('toResponse')
                ->with($request)
                ->willReturn($response);
            $factory = $this->createMock(ResponseFactory::class);
            $factory->expects($this->never())
                ->method('json');

            $actual = (new CreateNoStoreResponseAction($factory, $request))->execute($resource);

            $this->assertSame($response, $actual);
            $this->assertSame(202, $actual->getStatusCode());
            $this->assertSame([
                'data' => [
                    'value' => 'resource',
                ],
            ], $actual->getData(true));
            $this->assertSame('no-store, private', $actual->headers->get('Cache-Control'));
        }
    }

    public function testCollectionResponseUsesInjectedFactoryAndPreservesContent(): void
    {
        $collection = new Collection([
            'value' => 'collection',
        ]);
        $response = new JsonResponse($collection);
        $factory = $this->createMock(ResponseFactory::class);
        $factory->expects($this->once())
            ->method('json')
            ->with($collection)
            ->willReturn($response);

        $actual = (new CreateNoStoreResponseAction($factory, new Request()))->execute($collection);

        $this->assertSame($response, $actual);
        $this->assertSame([
            'value' => 'collection',
        ], $actual->getData(true));
        $this->assertSame('no-store, private', $actual->headers->get('Cache-Control'));
    }
}
