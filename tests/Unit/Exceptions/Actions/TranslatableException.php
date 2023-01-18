<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Exceptions\Actions;

use Exception;
use LaraStrict\Http\Exceptions\TranslatableHttpExceptionInterface;

class TranslatableException extends Exception implements TranslatableHttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return 401;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function getReplaceArrayForTranslation(): array
    {
        return [
            'key' => 'test',
        ];
    }
}
