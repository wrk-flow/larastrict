<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use LaraStrict\Http\Enums\HttpMessage;

class CreatedResource extends MessageResource
{
    public function __construct(
        public readonly int|string|null $id,
    ) {
        parent::__construct(HttpMessage::Created);
    }

    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'data' => [
                'id' => $this->id,
            ],
        ]);
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)
            ->setStatusCode(201);
    }
}
