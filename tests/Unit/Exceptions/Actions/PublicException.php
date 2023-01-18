<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Exceptions\Actions;

use Exception;
use LaraStrict\Http\Exceptions\MessageHttpExceptionInterface;

class PublicException extends Exception implements MessageHttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return 401;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function getPublicMessage(): string
    {
        return 'My message';
    }
}
