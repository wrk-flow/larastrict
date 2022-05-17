<?php

declare(strict_types=1);

namespace LaraStrict\Http\Resources;

use LaraStrict\Http\Enums\HttpMessage;

class CreatedResponse extends MessageResponse
{
    public function __construct(private readonly ?int $id)
    {
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
}
