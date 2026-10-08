<?php

declare(strict_types=1);

namespace LaraStrict\Http\Actions;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CreateNoStoreResponseAction
{
    public function __construct(
        private readonly ResponseFactory $responseFactory,
        private readonly Request $request,
    ) {
    }

    /**
     * @template TKey of array-key
     * @template TValue
     *
     * @param JsonResource|Collection<TKey, TValue> $resource
     */
    public function execute(JsonResource|Collection $resource): JsonResponse
    {
        $response = $resource instanceof JsonResource
            ? $resource->toResponse($this->request)
            : $this->responseFactory->json($resource);

        $response->headers->set('Cache-Control', 'private, no-store');

        return $response;
    }
}
