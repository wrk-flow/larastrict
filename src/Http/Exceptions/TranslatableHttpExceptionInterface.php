<?php

declare(strict_types=1);

namespace LaraStrict\Http\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

interface TranslatableHttpExceptionInterface extends HttpExceptionInterface
{
    /**
     * @return array<string, string|int|float>
     */
    public function getReplaceArrayForTranslation(): array;
}
